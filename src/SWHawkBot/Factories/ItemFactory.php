<?php
namespace SWHawkBot\Factories;

use SWHawkBot\GW2ApiBot\GW2ItemBot;
use SWHawkBot\Constants;
use SWHawkBot\Entities\Weapon;
use SWHawkBot\Entities\Armor;
use SWHawkBot\Entities\Bag;
use SWHawkBot\Entities\Trinket;
use SWHawkBot\Entities\Container;

class ItemFactory
{

    public static function returnItem($id)
    {
        $itemBot = GW2ItemBot::getItemBotInstance("1", "fr");
        $itemRaw = $itemBot->getItemRaw($id);
        if (!is_null($itemRaw)) {
            if (isset($itemRaw[strtolower($itemRaw['type'])]['type'])) {
                $itemSpecificType = $itemRaw[strtolower($itemRaw['type'])]['type'];
                if (array_key_exists($itemSpecificType, Constants::$translation['item_types']['Weapon']))
                {
                    return new Weapon($itemRaw);
                }

                if (array_key_exists($itemSpecificType, Constants::$translation['item_types']['Armor']))
                {
                    return new Armor($itemRaw);
                }
                if (array_key_exists($itemSpecificType, Constants::$translation['item_types']['Trinket']))
                {
                    return new Trinket($itemRaw);
                }
            }
            $itemType = $itemRaw['type'];
            if (array_key_exists($itemType, Constants::$translation['item_types']['Bag'])) {
                return new Bag($itemRaw);
            }

            if (array_key_exists($itemType, Constants::$translation['item_types']['Container'])) {
                return new Container($itemRaw);
            }
        }
    }
}