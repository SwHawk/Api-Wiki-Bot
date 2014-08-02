<?php

require_once __DIR__.'/../bootstrap/doctrine-bootstrap.php';

use SWHawkBot\GW2ApiBot\GW2ItemBot;
use SWHawkBot\Factories\ItemFactory;

$itemBot = GW2ItemBot::getItemBotInstance("1","fr",4);

$itemIds = $itemBot->getItemIds();

sort($itemIds);

$numberOfIds = count($itemIds);

for ( $i = 1 ; $i < 50 ; $i++)
{
    $item = ItemFactory::returnItem($itemIds[$numberOfIds - $i]);
    echo "L'objet ayant pour id : ".$item->getGw2ApiId()." a pour nom : ".$item->getName()."\n".
        "\tIl est de type : ".$item->getType()."\n";
}

?>