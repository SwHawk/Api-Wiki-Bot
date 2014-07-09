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
            "Longbow" => "Arc long",
            "Mace" => "Masse",
            "Pistol" => "Pistolet",
            "Rifle" => "Fusil",
            "Scepter" => "Sceptre",
            "Shield" => "Bouclier",
            "Shortbow" => "Arc court",
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
            "Potion" => "Potion",
            "Refinement" => "Rafinnage",
            "RefinementEctoplasm" => "Raffinage d'ectoplasme",
            "RefinementObsidian" => "Raffinage d'obsidienne",
            "UpgradeComponent" => "Composant d'amélioration"
        ),
        'recipe_discovery' => array(
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
                "Mace" => "Masse",
                "Pistol" => "Pistolet",
                "Rifle" => "Fusil",
                "Scepter" => "Sceptre",
                "Shield" => "Bouclier",
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
            "Bag" => "Sac",
            "Consumable" => array(
                "Food" => "Nourriture",
                "Generic" => "Consommable",
                "Unlock" => array(
                    "Dye" => "Teinture",
                    "CraftingRecipe" => "Recette"
                )
            ),
            "Container" => "Conteneur"
        ),
        'rarity' => array(
            "Junk" => "Déchet",
            "Basic" => "Simple",
            "Fine" => "Raffiné",
            "Masterwork" => "Chef-d'œuvre",
            "Rare" => "Rare",
            "Exotic" => "Exotique",
            "Ascended" => "Elevé",
            "Legendary" => "Légendaire"
        )
    );
}