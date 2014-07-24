<?php
namespace SWHawkBot;

abstract class Constants
{

    public static $translation = array(
        'recipe_types' => array(
            /**
             * Correspondances pour bijoutier
             */
            "Amulet" => "Amulettes",
            "Earring" => "Boucles d'oreille",
            "Ring" => "Anneaux",
            /**
             * Correspondances pour armures
             */
            "Bag" => "Sac",
            "Boots" => "Botte",
            "Bulk" => "En vrac",
            "Coat" => "Manteau",
            "Gloves" => "Gant",
            "Helm" => "Heaume",
            "HelmAquatic" => "Heaume",
            "Leggings" => "Jambière",
            "Shoulders" => "Epaulière",
            /**
             * Correspondances pour les armes
             */
            "Axe" => "Hache",
            "Dagger" => "Dague",
            "Focus" => "Focus",
            "Greatsword" => "Espadon",
            "Hammer" => "Marteau",
            "Harpoon" => "Lance",
            "LongBow" => "Arc long",
            "Mace" => "Masse",
            "Pistol" => "Pistolet",
            "Rifle" => "Fusil",
            "Scepter" => "Sceptre",
            "Shield" => "Bouclier",
            "ShortBow" => "Arc court",
            "Speargun" => "Fusil-harpon",
            "Staff" => "Bâton",
            "Sword" => "Epée",
            "Torch" => "Torche",
            "Trident" => "Trident",
            "Warhorn" => "Cor de guerre",
            /**
             * Correspondances pour les produits
             * de maître-queux
             */
            "Consumable" => "Consommable",
            "Dessert" => "Dessert",
            "Dye" => "Teinture",
            "Feast" => "Festin",
            "IngredientCooking" => "Ingrédient culinaire",
            "Meal" => "Plat",
            "Seasoning" => "Assaisonnement",
            "Snack" => "En-cas",
            "Soupe" => "Soupe",
            /**
             * Correspondances pour les généralités
             * d'artisanat
             */
            "Component" => "Composant d'artisanat",
            "Inscription" => "Inscription",
            "Insignia" => "Insigne",
            "Potion" => "Potion",
            "Refinement" => "Rafinnage",
            "RefinementEctoplasm" => "Raffinage d'ectoplasme",
            "RefinementObsidian" => "Raffinage d'obsidienne",
            "UpgradeComponent" => "Composant d'amélioration"
        ),
        'recipe_discovery' => array(
            "API_strings" => array(
                "APIAutoLearned" => "AutoLearned",
                "APILearnedFromItem" => "LearnedFromItem"
            ),
            "AutoLearned" => "Automatique",
            "LearnedFromItem" => "Achetable",
            "Discovered" => "Découverte",
            "Mystical" => "Forge Mystique"
        ),
        'crafting_disciplines' => array(
            "Armorsmith" => "Forgeron d'armures",
            "Artificer" => "Artificier",
            "Chef" => "Maître-queux",
            "Huntsman" => "Chasseur",
            "Jeweler" => "Bijoutier",
            "Leatherworker" => "Travailleur du cuir",
            "Tailor" => "Tailleur",
            "Weaponsmith" => "Forgeron d'armes"
        ),
        'armor_weight' => array(
            "Heavy" => "Lourd",
            "Light" => "Léger",
            "Medium" => "Intermédiaire"
        ),
        'item_types' => array(
            "Weapon" => array(
                "Axe" => "Hache",
                "Dagger" => "Dague",
                "Focus" => "Focus",
                "Greatsword" => "Espadon",
                "Hammer" => "Marteau",
                "Harpoon" => "Lance",
                "Longbow" => "Arc long",
                "LongBow" => "Arc long",
                "Mace" => "Masse",
                "Pistol" => "Pistolet",
                "Rifle" => "Fusil",
                "Scepter" => "Sceptre",
                "Shield" => "Bouclier",
                "ShortBow" => "Arc court",
                "Shortbow" => "Arc court",
                "Speargun" => "Fusil-harpon",
                "Staff" => "Bâton",
                "Sword" => "Epée",
                "Torch" => "Torche",
                "Trident" => "Trident",
                "Warhorn" => "Cor de guerre"
            ),
            "Armor" => array(
                "Boots" => "Botte",
                "Coat" => "Manteau",
                "Gloves" => "Gant",
                "Helm" => "Heaume",
                "HelmAquatic" => "Heaume",
                "Leggings" => "Jambière",
                "Shoulders" => "Epaulière"
            ),
            "Trinket" => array(
                "Accessory" => "Accessoire",
                "Amulet" => "Amulette",
                "Earring" => "Accessoire",
                "Ring" => "Anneau",
                "Trinket" => "Accessoire"
            ),
            "Back" => array(
                "Back" => "Sac à dos"
            ),
            "Bag" => array(
                "Bag" => "Sac",
            ),
            "Consumable" => array(
                "Booze" => "Alcool",
                "Food" => "Nourriture",
                "Generic" => "Consommable",
                "Unlock" => "Déblocage",
                "Utility" => "Utilitaire"
            ),
            "Container" => array(
                "Default" => "Conteneur",
                "GiftBox" => "GiftBox"
            ),
            "CraftingMaterial" => array(
                "CraftingMaterial" => "Matériau d'artisanat"
            ),
            "Gizmo" => array(
                "Default" => "Gizmo"
            ),
            "Trophy" => array(
                "Trophy" => "Trophée"
            ),
            "UpgradeComponent" => array(
                "Default" => "Bijou",
                "Gem" => "Gemme",
                "Sigil" => "Cachet",
                "Rune" => "Rune"
            )
        ),
        "rarity" => array(
            "Junk" => "Déchet",
            "Basic" => "Simple",
            "Fine" => "Raffiné",
            "Masterwork" => "Chef-d'œuvre",
            "Rare" => "Rare",
            "Exotic" => "Exotique",
            "Ascended" => "Elevé",
            "Legendary" => "Légendaire"
        ),
        "damage_types" => array(
            "Choking" => "Ténèbres",
            "Fire" => "Feu",
            "Ice" => "Glace",
            "Lightning" => "Air",
            "Physical" => "Physique"
        ),
        "infusion_types" => array(
            "Defense" => "Défensive",
            "Offense" => "Offensive",
            "Utilitary" => "Utilitaire"
        ),
        "attributes_modifier_functions" => array(
            "ConditionDamage" => "setDegatsAlterationModifier",
            "CritDamage" => "setFerociteModifier",
            "Healing" => "setGuerisonModifier",
            "Power" => "setPuissanceModifier",
            "Precision" => "setPrecisionModifier",
            "Toughness" => "setRobustesseModifier",
            "Vitality" => "setVitaliteModifier"
        ),
        "item_flags" => array(
            "soul_binding" => array (
                "SoulBindOnUse" => "Utilisation",
                "SoulBindOnAcquire" => "Acquisition",
                "SoulBind" => "Ame"
            ),
            "account_binding" => array(
                "AccountBound" => "Oui",
                "AccountBindOnUse" => "cu",
                "AccountBindOnAcquire" => "ca"
            )
        )
    );

    public static $types = array(
        "Weapons" => array(
            "Axe",
            "Dagger",
            "Focus",
            "Greatsword",
            "Hammer",
            "Harpoon",
            "Longbow",
            "Mace",
            "Pistol",
            "Rifle",
            "Scepter",
            "Shield",
            "Shortbow",
            "Speargun",
            "Staff",
            "Sword",
            "Torch",
            "Trident",
            "Warhorn"
        ),
        "Armors" => array(
            "Boots",
            "Coat",
            "Gloves",
            "Helm",
            "HelmAquatic",
            "Leggings",
            "Shoulders"
        ),
        "Trinkets" => array(
            "Amulet",
            "Earring",
            "Ring",
            "Trinket"
        ),
        "Bags" => array(
            "Bag"
        ),
        "Containers" => array(
            "Containers"
        ),
        "Backpacks" => array(
            "Backpack"
        ),
        "CrafintMaterials" => array(
            "Component" => "Composant d'artisanat",
            "Inscription" => "Inscription",
            "Insignia" => "Insigne",
            "UpgradeComponent" => "Composant d'amélioration"

        )
    );
}

?>