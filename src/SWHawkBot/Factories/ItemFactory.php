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
        if (!is_null($itemRaw))
        {
            $itemSpecificType = $itemRaw[strtolower($itemRaw['type'])]['type'];
            if (in_array($itemSpecificType, array(
                Constants::API_WEAPON_TYPE_AXE,
                Constants::API_WEAPON_TYPE_DAGGER,
                Constants::API_WEAPON_TYPE_FOCUS,
                Constants::API_WEAPON_TYPE_GREATSWORD,
                Constants::API_WEAPON_TYPE_HAMMER,
                Constants::API_WEAPON_TYPE_HARPOON,
                Constants::API_WEAPON_TYPE_LONGBOW,
                Constants::API_WEAPON_TYPE_MACE,
                Constants::API_WEAPON_TYPE_PISTOL,
                Constants::API_WEAPON_TYPE_RIFLE,
                Constants::API_WEAPON_TYPE_SCEPTER,
                Constants::API_WEAPON_TYPE_SHIELD,
                Constants::API_WEAPON_TYPE_SHORTBOW,
                Constants::API_WEAPON_TYPE_SPEARGUN,
                Constants::API_WEAPON_TYPE_STAFF,
                Constants::API_WEAPON_TYPE_SWORD,
                Constants::API_WEAPON_TYPE_TORCH,
                Constants::API_WEAPON_TYPE_TRIDENT,
                Constants::API_WEAPON_TYPE_WARHORN
            )))
            {
                return new Weapon($itemRaw);
            }

            if (in_array($itemSpecificType, array(
                Constants::API_ARMOR_TYPE_BOOTS,
                Constants::API_ARMOR_TYPE_COAT,
                Constants::API_ARMOR_TYPE_GLOVES,
                Constants::API_ARMOR_TYPE_HELM,
                Constants::API_ARMOR_TYPE_HELMAQUATIC,
                Constants::API_ARMOR_TYPE_LEGGINGS,
                Constants::API_ARMOR_TYPE_SHOULDERS
            ))) {
                return new Armor($itemRaw);
            }

            if ($itemSpecificType == Constants::API_TYPE_BAG)
            {
                return new Bag($itemRaw);
            }

            if ($itemSpecificType == Constants::API_TYPE_BULK)
            {
                return new Container($itemRaw);
            }

            if (in_array($itemSpecificType, array(
                Constants::API_TRINKET_TYPE_AMULET,
                Constants::API_TRINKET_TYPE_EARRING,
                Constants::API_TRINKET_TYPE_RING,
                Constants::API_TRINKET_TYPE_TRINKET
            ))) {
                return new Trinket($itemRaw);
            }
        }

    }
}