<?php
namespace SWHawkBot\Factories;

use SWHawkBot\GW2ApiBot\GW2ItemBot;
use SWHawkBot\Constants;
use SWHawkBot\Entities\Armor;
use SWHawkBot\Entities\Bag;
use SWHawkBot\Entities\Back;
use SWHawkBot\Entities\Consumable;
use SWHawkBot\Entities\Container;
use SWHawkBot\Entities\CraftingMaterial;
use SWHawkBot\Entities\Gizmo;
use SWHawkBot\Entities\Trinket;
use SWHawkBot\Entities\Trophy;
use SWHawkBot\Entities\UpgradeComponent;
use SWHawkBot\Entities\Weapon;

class ItemFactory
{

    public static function returnItem($id)
    {
        $itemBot = GW2ItemBot::getItemBotInstance("1", "fr", 3);
        $itemRaw = $itemBot->getItemRaw($id);
        $itemTypesArray = Constants::$translation['item_types'];
        if (!is_null($itemRaw)) {
            $itemType = $itemRaw['type'];
            if (isset($itemRaw[strtolower($itemRaw['type'])]['type'])) {
                $itemSpecificType = $itemRaw[strtolower($itemRaw['type'])]['type'];
                if (array_key_exists($itemSpecificType, $itemTypesArray['Armor']))
                {
                    return new Armor($itemRaw);
                }

                if (array_key_exists($itemSpecificType, $itemTypesArray['Consumable']))
                {
                    return new Consumable($itemRaw);
                }

                if ($itemType == "Container" && array_key_exists($itemSpecificType, $itemTypesArray['Container']))
                {
                    return new Container($itemRaw);
                }

                if ($itemType == "Gizmo" && array_key_exists($itemSpecificType, $itemTypesArray['Gizmo']))
                {
                    return new Gizmo($itemRaw);
                }

                if (array_key_exists($itemSpecificType, $itemTypesArray['Trinket']))
                {
                    return new Trinket($itemRaw);
                }

                if (array_key_exists($itemSpecificType, $itemTypesArray['Weapon']))
                {
                    return new Weapon($itemRaw);
                }
            }

            if (isset($itemRaw['upgrade_component']['type']))
            {
                return new UpgradeComponent($itemRaw);
            }

            if (array_key_exists($itemType, $itemTypesArray['Bag']))
            {
                return new Bag($itemRaw);
            }

            if (array_key_exists($itemType, $itemTypesArray['Back']))
            {
                return new Back($itemRaw);
            }

            if (array_key_exists($itemType, $itemTypesArray['CraftingMaterial']))
            {
                return new CraftingMaterial($itemRaw);
            }

            if (array_key_exists($itemType, $itemTypesArray['Trophy']))
            {
                return new Trophy($itemRaw);
            }
        }
    }
}