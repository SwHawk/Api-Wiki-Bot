<?php

require_once __DIR__.'/../bootstrap/doctrine-bootstrap.php';

use SWHawkBot\GW2WikiBot\GW2WikiBot;
use Symfony\Component\Yaml\Parser;

$yamlParser = new Parser();

$config = $yamlParser->parse(file_get_contents(__DIR__.'/../config/config.yaml'))['wikiBotConfig'];

$wikiBot = GW2WikiBot::getGW2WikiBotInstance($config['WikiTestAdmin']);

$wikiBot->login();

$pages = array();


$queryContinue = '';

do {
    if ($queryContinue == '')
    {
         $allpagesresponse = $wikiBot->client->get(null, array(
               'query' => array(
                'action' => 'query',
                'list' => 'allpages',
                'aplimit' => 2500,
            )
         ))->json();
    } else {
        $allpagesresponse = $wikiBot->client->get(null, array(
            'query' => array(
                'action' => 'query',
                'list' => 'allpages',
                'aplimit' => 2500,
                'apcontinue' => $queryContinue
            )
        ))->json();
    }

    foreach($allpagesresponse['query']['allpages'] as $page)
    {
        $pages[] = array('pageid' => $page['pageid'], 'title' => $page['title']);
    }

    if (isset($allpagesresponse['query-continue']['allpages']))
    {
        $queryContiur = $allpagesresponse['query-continue']['allpages']['apcontinue'];
    }

} while (isset($allpagesresponse['query-continue']['allpages']));

foreach($pages as $page)
{
    if ($page['title'] == "Accueil")
    {
        continue;
    }
    $token = $wikiBot->client->get(null, array(
        'query' => array(
            'action' => 'tokens',
            'type' => 'delete'
        )
    ))->json()['tokens']['deletetoken'];
    $deleteResponse = $wikiBot->client->post(null, array(
        'query' => array(
            'action' => 'delete',
            'pageid' => $page['pageid'],
            'token' => $token
        )
    ))->json();
    echo "La page : ".$deleteResponse['delete']['title']." a bien été supprimée\n";
}