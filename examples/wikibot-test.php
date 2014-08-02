<?php

require_once __DIR__.'/../bootstrap/doctrine-bootstrap.php';

use SWHawkBot\GW2WikiBot\GW2WikiBot;
use Symfony\Component\Yaml\Parser;
use Doctrine\Common\Collections\ArrayCollection;

$yamlParser = new Parser();

$config = $yamlParser->parse(file_get_contents(__DIR__.'/../config/config.yaml'))['wikiBotConfig'];

$dql = "SELECT r".
    " FROM SWHawkBot\Entities\Recipe r".
    " JOIN r.outputItemAssociator ia".
    " WHERE r.difficulty BETWEEN :min AND :max ".
    " AND r.type LIKE :type".
    " AND r.disciplines LIKE :discipline".
    " ORDER BY ia.itemName ASC, ia.itemRarity ASC";

$recipeRepo = $entityManager->getRepository("SWHawkBot\Entities\Recipe");

$copperAmuletRecipes = $entityManager->createQuery($dql)->setParameter('type','%%')
    ->setParameter('discipline', '%Bijoutier%')
    ->setParameter('min', 0)
    ->setParameter('max', 400)->getResult();

$copperAmulets = new ArrayCollection();

foreach($copperAmuletRecipes as $recipe)
{
    $copperAmulets->add($recipe->getOutputItemAssociator()->getRealItem());
}

$pagestobeadded = array();
$lastpagename = "";

foreach($copperAmulets as $amulet)
{
    if ($lastpagename != $amulet->getName())
    {
        if ($lastpagename != "")
        {
            $pagestobeadded[] = $page;
        }
        $page = array();
        $page['title'] = $amulet->getName();
        $page['text'] = "Nom : ".$amulet->getName()."<br/>Niveau : ".$amulet->getLevel()."<br/>Rareté : ".$amulet->getRarity()."\n";
        $lastpagename = $amulet->getName();
    } else {
        $page['text'] .= "==".$amulet->getRarity()."==\nNom : ".$amulet->getName().
            "<br/>Niveau : ".$amulet->getLevel()."<br/>Rareté : ".$amulet->getRarity()."\n";
    }
}

//print_r($pagestobeadded);

$wikiBot = GW2WikiBot::getGW2WikiBotInstance($config['WikiTestBot']);

$wikiBot->login();

foreach($pagestobeadded as $page)
{
    $token = $wikiBot->client->get( null, array(
        'query' => array(
            'action' => 'tokens',
            'type' => 'edit'
        )
    ))->json()['tokens']['edittoken'];
    $wikiBot->client->post( null, array(
        'query' => array(
            'action' => 'edit',
            'title' => $page['title'],
            'text' => $page['text'],
            'token' => $token,
            'recreate' => '',
            'bot' => ''
        )
    ));
    echo "La page intitulée : ".$page['title']." a bien été ajoutée au wiki\n";
}

?>