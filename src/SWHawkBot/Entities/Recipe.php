<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle de donnée des recettes d'artisanat de
 * GuildWars 2
 *
 * @author SwHawk
 *        
 *         @ORM\Entity @ORM\Table(name="Recipes")
 */
class Recipe
{

    /**
     * Identifiant de la recette en base de données
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    protected $id;

    /**
     * Identifiant de la recette pour l'API GuildWars2
     *
     * @ORM\Column(type="integer", unique=true)
     *
     * @var integer
     */
    protected $gw2apiId;

    /**
     * Type de la recette dans la discipline d'artisanat
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $type;

    /**
     * Identifiant (Gw2apiId) de l'arme produite par la
     * recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $weaponOutputItemId;

    /**
     * Identifiant (Gw2apiId) de la pièce d'armure
     * produite par la recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $armorOutputItemId;

    /**
     * Identifiant (Gw2apiId) de l'accessoire produit
     * par la recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $trinketOutputItemId;

    /**
     * Identifiant (Gw2apiId) du consommable produit
     * par la recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $consumableOutputItemId;

    /**
     * Identifiant (Gw2apiId) du sac produit par la
     * recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $bagOutputItemId;

    /**
     * Identifiant (Gw2apiId) du composant d'artisanat
     * produit par la recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $craftingMaterialOutputItemId;

    /**
     * Identifiant (Gw2apiId) du composant d'amélioration
     * produit par la recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $upgradeComponentOutputItemId;

    /**
     * Identifiant (Gw2apiId) de la sacoche d'armure
     * produite par la recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $containerOutputItemId;

    /**
     * Identifiant (Gw2apiId) de l'objet de dos produit
     * par la recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $backpackOutputItemId;

    /**
     * Nombre d'objets produits par la recette
     *
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $output_item_count;

    /**
     * Niveau minimum d'artisanat pour pouvoir
     * suivre la recette
     *
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $difficulty;

    /**
     * Disciplines d'artisanat capables de suivre
     * la recette
     *
     * @ORM\Column(type="string")
     *
     * @var array
     */
    protected $disciplines;

    /**
     * Identifiant (Gw2apiId) du premier ingrédient
     * de la recette
     *
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $mat1Id;

    /**
     * Quantité nécessaire du premier ingrédient
     *
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $mat1Qty;

    /**
     * Identifiant (Gw2apiId) du deuxième ingrédient
     * de la recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $mat2Id = null;

    /**
     * Quantité nécessaire du deuxième ingrédient
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $mat2Qty = null;

    /**
     * Identifiant (Gw2apiId) du troisième ingrédient
     * de la recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $mat3Id = null;

    /**
     * Quantité nécessaire du troisième ingrédient
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $mat3Qty = null;

    /**
     * Identifiant (Gw2apiId) du quatrième ingrédient
     * de la recette
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $mat4Id = null;

    /**
     * Quantité nécessaire du quatrième ingrédient
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $mat4Qty = null;

    /**
     * Méthode de découverte de la recette
     *
     * Valeurs possibles : Automatique, Achetable, Découverte,
     * Forge Mystique
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $discovery;

    /**
     * Correspondances API/wiki-fr pour les méthodes
     * de découverte de recettes
     */
    const API_RECIPE_AUTO_LEARNED = "AutoLearned";

    const API_RECIPE_BOUGHT = "LearnedFromItem";

    const RECIPE_DISCOVERED = "Découverte";

    const RECIPE_AUTO_LEARNED = "Automatique";

    const RECIPE_BOUGHT = "Achetable";

    const RECIPE_MYSTICAL = "Forge mystique";

    /**
     * Correspondances API/wiki-fr Bijoutier
     */
    const API_TYPE_RING = "Ring";

    const TYPE_RING = "Bague";

    const API_TYPE_AMULET = "Amulet";

    const TYPE_AMULET = "Amulette";

    const API_TYPE_EARRING = "Earring";

    const TYPE_EARRING = "Boucle d'oreille";

    /**
     * Correspondances API/wiki-fr Armes
     */
    const API_TYPE_AXE = "Axe";

    const TYPE_AXE = "Hache";

    const API_TYPE_DAGGER = "Dagger";

    const TYPE_DAGGER = "Dague";

    const API_TYPE_FOCUS = "Focus";

    const TYPE_FOCUS = "Focus";

    const API_TYPE_GREATSWORD = "Greatsword";

    const TYPE_GREATSWORD = "Espadon";

    const API_TYPE_HAMMER = "Hammer";

    const TYPE_HAMMER = "Marteau";

    const API_TYPE_HARPOON = "Harpoon";

    const TYPE_HARPOON = "Lance";

    const API_TYPE_LONGBOW = "LongBow";

    const TYPE_LONGBOW = "Arc long";

    const API_TYPE_MACE = "Mace";

    const TYPE_MACE = "Masse";

    const API_TYPE_PISTOL = "Pistol";

    const TYPE_PISTOL = "Pistolet";

    const API_TYPE_RIFLE = "Rifle";

    const TYPE_RIFLE = "Fusil";

    const API_TYPE_SCEPTER = "Scepter";

    const TYPE_SCEPTER = "Sceptre";

    const API_TYPE_SHIELD = "Shield";

    const TYPE_SHIELD = "Bouclier";

    const API_TYPE_SHORTBOW = "ShortBow";

    const TYPE_SHORTBOW = "Arc court";

    const API_TYPE_SPEARGUN = "Speargun";

    const TYPE_SPEARGUN = "Fusil-harpon";

    const API_TYPE_STAFF = "Staff";

    const TYPE_STAFF = "Bâton";

    const API_TYPE_SWORD = "Sword";

    const TYPE_SWORD = "Epée";

    const API_TYPE_TORCH = "Torch";

    const TYPE_TORCH = "Torche";

    const API_TYPE_TRIDENT = "Trident";

    const TYPE_TRIDENT = "Trident";

    const API_TYPE_WARHORN = "Warhorn";

    const TYPE_WARHORN = "Cor de guerre";

    const API_TYPE_INSCRIPTION = "Inscription";

    const TYPE_INSCRIPTION = "Inscription";

    /**
     * Correspondances API/wiki-fr Armures
     */
    const API_TYPE_INSIGNIA = "Insignia";

    const TYPE_INSIGNIA = "Insigne";

    const API_TYPE_BACKPACK = "Backpack";

    const TYPE_BACKPACK = "Sac à dos";

    const API_TYPE_BAG = "Bag";

    const TYPE_BAG = "Sac";

    const API_TYPE_BOOTS = "Boots";

    const TYPE_BOOTS = "Botte";

    const API_TYPE_BULK = "Bulk";

    const TYPE_BULK = "En vrac";

    const API_TYPE_COAT = "Coat";

    const TYPE_COAT = "Manteau";

    const API_TYPE_GLOVES = "Gloves";

    const TYPE_GLOVES = "Gant";

    const API_TYPE_HELM = "Helm";

    const TYPE_HELM = "Heaume";

    const API_TYPE_HELMAQUATIC = "HelmAquatic";

    const TYPE_HELMAQUATIC = "Heaume";

    const API_TYPE_LEGGINGS = "Leggings";

    const TYPE_LEGGINGS = "Jambière";

    const API_TYPE_SHOULDERS = "Shoulders";

    const TYPE_SHOULDERS = "Epaulière";

    /**
     * Correspondance API/wiki-fr Maître-queux
     */
    const API_TYPE_CONSUMABLE = "Consumable";

    const TYPE_CONSUMABLE = "Consommable";

    const API_TYPE_DESSERT = "Dessert";

    const TYPE_DESSERT = "Dessert";

    const API_TYPE_DYE = "Dye";

    const TYPE_DYE = "Teinture";

    const API_TYPE_FEAST = "Feast";

    const TYPE_FEAST = "Festin";

    const API_TYPE_INGREDIENT_COOKING = "IngredientCooking";

    const TYPE_INGREDIENT_COOKING = "Ingrédient Culinaire";

    const API_TYPE_MEAL = "Meal";

    const TYPE_MEAL = "Plat";

    const API_TYPE_SEASONING = "Seasoning";

    const TYPE_SEASONING = "Assaisonnement";

    const API_TYPE_SNACK = "Snack";

    const TYPE_SNACK = "En-cas";

    const API_TYPE_SOUP = "Soup";

    const TYPE_SOUP = "Soupe";

    /**
     * Correspondances API/wiki-fr Généralités artisanat
     */
    const API_TYPE_COMPONENT = "Component";

    const TYPE_COMPONENT = "Composant d'artisanat";

    const API_TYPE_POTION = "Potion";

    const TYPE_POTION = "Potion";

    const API_TYPE_REFINEMENT = "Refinement";

    const TYPE_REFINEMENT = "Rafinnage";

    const API_TYPE_REFINEMENT_ECTOPLASM = "RefinementEctoplasm";

    const TYPE_REFINEMENT_ECTOPLASM = "Raffinage d'ectoplasme";

    const API_TYPE_REFINEMENT_OBSIDIAN = "RefinementObsidian";

    const TYPE_REFINEMENT_OBSIDIAN = "Raffinage d'obsidienne";

    const API_TYPE_UPGRADE_COMPONENT = "UpgradeComponent";

    const TYPE_UPGRADE_COMPONENT = "Composant d'amélioration";

    /**
     * Correspondances API/wiki-fr Disciplines d'artisanat
     */
    const API_DISCIPLINE_ARMORSMITH = "Armorsmith";

    const DISCIPLINE_ARMORSMITH = "Forgeron d'armures";

    const API_DISCIPLINE_ARTIFICER = "Artificer";

    const DISCIPLINE_ARTIFICER = "Artificier";

    const API_DISCIPLINE_CHEF = "Chef";

    const DISCIPLINE_CHEF = "Maître-queux";

    const API_DISCIPLINE_HUNTSMAN = "Huntsman";

    const DISCIPLINE_HUNTSMAN = "Chasseur";

    const API_DISCIPLINE_JEWELER = "Jeweler";

    const DISCIPLINE_JEWELER = "Bijoutier";

    const API_DISCIPLINE_LEATHERWORKER = "Leatherworker";

    const DISCIPLINE_LEATHERWORKER = "Travailleur du cuir";

    const API_DISCIPLINE_TAILOR = "Tailor";

    const DISCIPLINE_TAILOR = "Tailleur";

    const API_DISCIPLINE_WEAPONSMITH = "Weaponsmith";

    const DISCIPLINE_WEAPONSMITH = "Forgeron d'armes";

    /**
     * Constructeur de la classe
     *
     * @param array $recipe            
     * @return Recipe
     */
    public function __construct($recipe = null)
    {
        if (is_null($recipe)) {
            return $this;
        }
        
        if (isset($recipe['recipe_id'])) {
            $this->setGw2apiId($recipe['recipe_id']);
        }
        
        if (isset($recipe['type'])) {
            $this->setType($recipe['type']);
        }
        
        if (isset($recipe['output_item_id'], $recipe['type'])) {
            $this->setOutputItemId($recipe['output_item_id'], $recipe['type']);
        }
        
        if (isset($recipe['output_item_count'])) {
            $this->setOutputItemCount($recipe['output_item_count']);
        }
        
        if (isset($recipe['min_rating'])) {
            $this->setDifficulty($recipe['min_rating']);
        }
        
        if (isset($recipe['disciplines'])) {
            $this->setDisciplines($recipe['disciplines']);
        }
        
        if (isset($recipe['flags'][0])) {
            $this->setDiscovery($recipe['flags'][0], $recipe['type']);
        } else {
            $this->setDiscovery(null, $recipe['type']);
        }
        
        if (isset($recipe['ingredients'])) {
            foreach ($recipe['ingredients'] as $number => $ingredient_details) {
                $idfunction = "setMat" . ($number + 1) . "Id";
                $qtyfunction = "setMat" . ($number + 1) . "Qty";
                $this->$idfunction($ingredient_details['item_id']);
                $this->$qtyfunction($ingredient_details['count']);
            }
        }
        
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setGw2apiId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->gw2apiId = $id;
        return $this;
    }

    /**
     *
     * @param string $type            
     * @return Recipe
     */
    public function setType($type)
    {
        if ($type == self::API_TYPE_AMULET) {
            $this->type = self::TYPE_AMULET;
            return $this;
        }
        
        if ($type == self::API_TYPE_AXE) {
            $this->type = self::TYPE_AXE;
            return $this;
        }
        
        if ($type == self::API_TYPE_BACKPACK) {
            $this->type = self::TYPE_BACKPACK;
            return $this;
        }
        
        if ($type == self::API_TYPE_BAG) {
            $this->type = self::TYPE_BAG;
            return $this;
        }
        
        if ($type == self::API_TYPE_BOOTS) {
            $this->type = self::TYPE_BOOTS;
            return $this;
        }
        
        if ($type == self::API_TYPE_BULK) {
            $this->type = self::TYPE_BULK;
            return $this;
        }
        
        if ($type == self::API_TYPE_COAT) {
            $this->type = self::TYPE_COAT;
            return $this;
        }
        
        if ($type == self::API_TYPE_COMPONENT) {
            $this->type = self::TYPE_COMPONENT;
            return $this;
        }
        
        if ($type == self::API_TYPE_CONSUMABLE) {
            $this->type = self::TYPE_CONSUMABLE;
            return $this;
        }
        
        if ($type == self::API_TYPE_DAGGER) {
            $this->type = self::TYPE_DAGGER;
            return $this;
        }
        
        if ($type == self::API_TYPE_DESSERT) {
            $this->type = self::TYPE_DESSERT;
            return $this;
        }
        
        if ($type == self::API_TYPE_DYE) {
            $this->type = self::TYPE_DYE;
            return $this;
        }
        
        if ($type == self::API_TYPE_EARRING) {
            $this->type = self::TYPE_EARRING;
            return $this;
        }
        
        if ($type == self::API_TYPE_FEAST) {
            $this->type = self::TYPE_FEAST;
            return $this;
        }
        
        if ($type == self::API_TYPE_FOCUS) {
            $this->type = self::TYPE_FOCUS;
            return $this;
        }
        
        if ($type == self::API_TYPE_GLOVES) {
            $this->type = self::TYPE_GLOVES;
            return $this;
        }
        
        if ($type == self::API_TYPE_GREATSWORD) {
            $this->type = self::TYPE_GREATSWORD;
            return $this;
        }
        
        if ($type == self::API_TYPE_HAMMER) {
            $this->type = self::TYPE_HAMMER;
            return $this;
        }
        
        if ($type == self::API_TYPE_HELM) {
            $this->type = self::TYPE_HELM;
            return $this;
        }
        
        if ($type == self::API_TYPE_INGREDIENT_COOKING) {
            $this->type = self::TYPE_INGREDIENT_COOKING;
            return $this;
        }
        
        if ($type == self::API_TYPE_INSCRIPTION) {
            $this->type = self::TYPE_INSCRIPTION;
            return $this;
        }
        
        if ($type == self::API_TYPE_INSIGNIA) {
            $this->type = self::TYPE_INSIGNIA;
            return $this;
        }
        
        if ($type == self::API_TYPE_LEGGINGS) {
            $this->type = self::TYPE_LEGGINGS;
            return $this;
        }
        
        if ($type == self::API_TYPE_LONGBOW) {
            $this->type = self::TYPE_LONGBOW;
            return $this;
        }
        
        if ($type == self::API_TYPE_MACE) {
            $this->type = self::TYPE_MACE;
            return $this;
        }
        
        if ($type == self::API_TYPE_MEAL) {
            $this->type = self::TYPE_MEAL;
            return $this;
        }
        
        if ($type == self::API_TYPE_PISTOL) {
            $this->type = self::TYPE_PISTOL;
            return $this;
        }
        
        if ($type == self::API_TYPE_POTION) {
            $this->type = self::TYPE_POTION;
            return $this;
        }
        
        if ($type == self::API_TYPE_REFINEMENT) {
            $this->type = self::TYPE_REFINEMENT;
            return $this;
        }
        
        if ($type == self::API_TYPE_REFINEMENT_ECTOPLASM) {
            $this->type = self::TYPE_REFINEMENT_ECTOPLASM;
            return $this;
        }
        
        if ($type == self::API_TYPE_REFINEMENT_OBSIDIAN) {
            $this->type = self::TYPE_REFINEMENT_OBSIDIAN;
            return $this;
        }
        
        if ($type == self::API_TYPE_RIFLE) {
            $this->type = self::TYPE_RIFLE;
            return $this;
        }
        
        if ($type == self::API_TYPE_RING) {
            $this->type = self::TYPE_RING;
            return $this;
        }
        
        if ($type == self::API_TYPE_SCEPTER) {
            $this->type = self::TYPE_SCEPTER;
            return $this;
        }
        
        if ($type == self::API_TYPE_SEASONING) {
            $this->type = self::TYPE_SEASONING;
            return $this;
        }
        
        if ($type == self::API_TYPE_SHIELD) {
            $this->type = self::TYPE_SHIELD;
            return $this;
        }
        
        if ($type == self::API_TYPE_SHORTBOW) {
            $this->type = self::TYPE_SHORTBOW;
            return $this;
        }
        
        if ($type == self::API_TYPE_SHOULDERS) {
            $this->type = self::TYPE_SHOULDERS;
            return $this;
        }
        
        if ($type == self::API_TYPE_SNACK) {
            $this->type = self::TYPE_SNACK;
            return $this;
        }
        
        if ($type == self::API_TYPE_SOUP) {
            $this->type = self::TYPE_SOUP;
            return $this;
        }
        
        if ($type == self::API_TYPE_SPEARGUN) {
            $this->type = self::TYPE_SPEARGUN;
            return $this;
        }
        
        if ($type == self::API_TYPE_STAFF) {
            $this->type = self::TYPE_STAFF;
            return $this;
        }
        
        if ($type == self::API_TYPE_SWORD) {
            $this->type = self::TYPE_SWORD;
            return $this;
        }
        
        if ($type == self::API_TYPE_TORCH) {
            $this->type = self::TYPE_TORCH;
            return $this;
        }
        
        if ($type == self::API_TYPE_TRIDENT) {
            $this->type = self::TYPE_TRIDENT;
            return $this;
        }
        
        if ($type == self::API_TYPE_UPGRADE_COMPONENT) {
            $this->type = self::TYPE_UPGRADE_COMPONENT;
            return $this;
        }
        
        if ($type == self::API_TYPE_WARHORN) {
            $this->type = self::TYPE_WARHORN;
            return $this;
        }
        $this->type = $type;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setWeaponOutputItemId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->weaponOutputItemId = $id;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setArmorOutputItemId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->armorOutputItemId = $id;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setTrinketOutputItemId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->trinketOutputItemId = $id;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setConsumabletOutputItemId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->consumableOutputItemId = $id;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setBagOutputItemId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->bagOutputItemId = $id;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setCraftingMaterialOutputItemId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->craftingMaterialOutputItemId = $id;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setUpgradeComponentOutputItemId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->upgradeComponentOutputItemId = $id;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setContainerOutputItemId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->containerOutputItemId = $id;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setBackpackOutputItemId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->backpackOutputItemId = $id;
        return $this;
    }

    /**
     * Setter général pour .
     *
     * ..OutputItemId, en fonction du type
     *
     * @param integer $id            
     * @param string $type            
     * @return \SWHawkBot\Entities\Recipe
     */
    public function setOutputItemId($id, $type)
    {
        if (in_array($type, array(
            self::API_TYPE_AMULET,
            self::API_TYPE_EARRING,
            self::API_TYPE_RING
        ))) {
            $this->setTrinketOutputItemId($id);
        }
        if (in_array($type, array(
            self::API_TYPE_BOOTS,
            self::API_TYPE_HELM,
            self::API_TYPE_COAT,
            self::API_TYPE_GLOVES,
            self::API_TYPE_LEGGINGS,
            self::API_TYPE_SHOULDERS,
            self::API_TYPE_HELMAQUATIC
        ))) {
            $this->setArmorOutputItemId($id);
        }
        if (in_array($type, array(
            self::API_TYPE_AXE,
            self::API_TYPE_DAGGER,
            self::API_TYPE_FOCUS,
            self::API_TYPE_GREATSWORD,
            self::API_TYPE_HAMMER,
            self::API_TYPE_HARPOON,
            self::API_TYPE_LONGBOW,
            self::API_TYPE_MACE,
            self::API_TYPE_PISTOL,
            self::API_TYPE_RIFLE,
            self::API_TYPE_SCEPTER,
            self::API_TYPE_SHIELD,
            self::API_TYPE_SHORTBOW,
            self::API_TYPE_SPEARGUN,
            self::API_TYPE_STAFF,
            self::API_TYPE_SWORD,
            self::API_TYPE_TORCH,
            self::API_TYPE_TRIDENT,
            self::API_TYPE_WARHORN
        ))) {
            $this->setWeaponOutputItemId($id);
        }
        
        if (in_array($type, array(
            self::API_TYPE_CONSUMABLE,
            self::API_TYPE_DESSERT,
            self::API_TYPE_DYE,
            self::API_TYPE_FEAST,
            self::API_TYPE_MEAL,
            self::API_TYPE_POTION,
            self::API_TYPE_SNACK,
            self::API_TYPE_SOUP
        ))) {
            $this->setConsumabletOutputItemId($id);
        }
        
        if (in_array($type, array(
            self::API_TYPE_BAG
        ))) {
            $this->setBagOutputItemId($id);
        }
        
        if (in_array($type, array(
            self::API_TYPE_COMPONENT,
            self::API_TYPE_INGREDIENT_COOKING,
            self::API_TYPE_INSCRIPTION,
            self::API_TYPE_INSIGNIA,
            self::API_TYPE_REFINEMENT,
            self::API_TYPE_REFINEMENT_ECTOPLASM,
            self::API_TYPE_REFINEMENT_OBSIDIAN
        ))) {
            $this->setCraftingMaterialOutputItemId($id);
        }
        
        if (in_array($type, array(
            self::API_TYPE_UPGRADE_COMPONENT
        ))) {
            $this->setUpgradeComponentOutputItemId($id);
        }
        
        if (in_array($type, array(
            self::API_TYPE_BULK
        ))) {
            $this->setContainerOutputItemId($id);
        }
        
        if (in_array($type, array(
            self::API_TYPE_BACKPACK
        ))) {
            $this->setBackpackOutputItemId($id);
        }
        return $this;
    }

    /**
     *
     * @param integer $count            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setOutputItemCount($count)
    {
        if (! is_numeric($count)) {
            throw new \InvalidArgumentException('La fonction attend un count entier. Count donné : ' . var_dump($count));
        }
        $this->output_item_count = $count;
        return $this;
    }

    /**
     *
     * @param integer $difficulty            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setDifficulty($difficulty)
    {
        if (! is_numeric($difficulty)) {
            throw new \InvalidArgumentException('La fonction attend une difficulté entière. Difficulté donnée : ' . var_dump($difficulty));
        }
        $this->difficulty = $difficulty;
        return $this;
    }

    /**
     *
     * @param string $type            
     * @param string $discovery            
     * @return Recipe
     */
    public function setDiscovery($type, $discovery = null)
    {
        if ($discovery == self::API_RECIPE_AUTO_LEARNED) {
            $this->discovery = self::RECIPE_AUTO_LEARNED;
            return $this;
        }
        if ($discovery == self::API_RECIPE_BOUGHT) {
            if ($type == self::API_TYPE_BULK || $type == self::API_TYPE_FEAST) {
                $this->discovery = self::RECIPE_MYSTICAL;
                return $this;
            } else {
                $this->discovery = self::RECIPE_BOUGHT;
                return $this;
            }
        } else {
            $this->discovery = self::RECIPE_DISCOVERED;
            return $this;
        }
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setMat1Id($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id de matériau entier. Id donné : ' . var_dump($id));
        }
        $this->mat1Id = $id;
        return $this;
    }

    /**
     *
     * @param integer $qty            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setMat1Qty($qty)
    {
        if (! is_numeric($qty)) {
            throw new \InvalidArgumentException('La fonction attend une quantité entière. Quantité donnée : ' . var_dump($qty));
        }
        $this->mat1Qty = $qty;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setMat2Id($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id de matériau entier. Id donné : ' . var_dump($id));
        }
        $this->mat2Id = $id;
        return $this;
    }

    /**
     *
     * @param integer $qty            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setMat2Qty($qty)
    {
        if (! is_numeric($qty)) {
            throw new \InvalidArgumentException('La fonction attend une quantité entière. Quantité donnée : ' . var_dump($qty));
        }
        $this->mat2Qty = $qty;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setMat3Id($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id de matériau entier. Id donné : ' . var_dump($id));
        }
        $this->mat3Id = $id;
        return $this;
    }

    /**
     *
     * @param integer $qty            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setMat3Qty($qty)
    {
        if (! is_numeric($qty)) {
            throw new \InvalidArgumentException('La fonction attend une quantité entière. Quantité donnée : ' . var_dump($qty));
        }
        $this->mat3Qty = $qty;
        return $this;
    }

    /**
     *
     * @param integer $id            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setMat4Id($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id de matériau entier. Id donné : ' . var_dump($id));
        }
        $this->mat4Id = $id;
        return $this;
    }

    /**
     *
     * @param integer $qty            
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setMat4Qty($qty)
    {
        if (! is_numeric($qty)) {
            throw new \InvalidArgumentException('La fonction attend une quantité entière. Quantité donnée : ' . var_dump($qty));
        }
        $this->mat4Qty = $qty;
        return $this;
    }

    /**
     *
     * @param array $disciplines            
     * @return Recipe
     */
    public function setDisciplines($disciplines)
    {
        foreach ($disciplines as &$discipline) {
            if ($discipline == self::API_DISCIPLINE_ARMORSMITH || $discipline == self::DISCIPLINE_ARMORSMITH) {
                $discipline = self::DISCIPLINE_ARMORSMITH;
            }
            if ($discipline == self::API_DISCIPLINE_ARTIFICER || $discipline == self::DISCIPLINE_ARTIFICER) {
                $discipline = self::DISCIPLINE_ARTIFICER;
            }
            if ($discipline == self::API_DISCIPLINE_CHEF || $discipline == self::DISCIPLINE_CHEF) {
                $discipline = self::DISCIPLINE_CHEF;
            }
            if ($discipline == self::API_DISCIPLINE_HUNTSMAN || $discipline == self::DISCIPLINE_HUNTSMAN) {
                $discipline = self::DISCIPLINE_HUNTSMAN;
            }
            if ($discipline == self::API_DISCIPLINE_JEWELER || $discipline == self::DISCIPLINE_JEWELER) {
                $discipline = self::DISCIPLINE_JEWELER;
            }
            if ($discipline == self::API_DISCIPLINE_LEATHERWORKER || $discipline == self::DISCIPLINE_LEATHERWORKER) {
                $discipline = self::DISCIPLINE_LEATHERWORKER;
            }
            if ($discipline == self::API_DISCIPLINE_TAILOR || $discipline == self::DISCIPLINE_TAILOR) {
                $discipline = self::DISCIPLINE_TAILOR;
            }
            if ($discipline == self::API_DISCIPLINE_WEAPONSMITH || $discipline == self::DISCIPLINE_WEAPONSMITH) {
                $discipline = self::DISCIPLINE_WEAPONSMITH;
            }
        }
        $this->disciplines = implode(", ", $disciplines);
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return integer
     */
    public function getGw2apiId()
    {
        return $this->gw2apiId;
    }

    /**
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @return integer
     */
    public function getOutputItemCount()
    {
        return $this->output_item_count;
    }

    /**
     *
     * @return integer
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     *
     * @return array
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }

    /**
     *
     * @return integer
     */
    public function getMat1Id()
    {
        return $this->mat1Id;
    }

    /**
     *
     * @return integer
     */
    public function getMat1Qty()
    {
        return $this->mat1Qty;
    }

    /**
     *
     * @return integer|null
     */
    public function getMat2Id()
    {
        return $this->mat2Id;
    }

    /**
     *
     * @return integer|null
     */
    public function getMat2Qty()
    {
        return $this->mat2Qty;
    }

    /**
     *
     * @return integer|null
     */
    public function getMat3Id()
    {
        return $this->mat3Id;
    }

    /**
     *
     * @return integer|null
     */
    public function getMat3Qty()
    {
        return $this->mat3Qty;
    }

    /**
     *
     * @return integer|null
     */
    public function getMat4Id()
    {
        return $this->mat4Id;
    }

    /**
     *
     * @return integer|null
     */
    public function getMat4Qty()
    {
        return $this->mat4Qty;
    }

    /**
     *
     * @return string
     */
    public function getDiscovery()
    {
        return $this->discovery;
    }

    /**
     *
     * @return integer|null
     */
    public function getArmorOutputItemId()
    {
        return $this->armorOutputItemId;
    }

    /**
     *
     * @return integer|null
     */
    public function getBagOutputItemId()
    {
        return $this->bagOutputItemId;
    }

    /**
     *
     * @return integer|null
     */
    public function getConsumableOutputItemId()
    {
        return $this->consumableOutputItemId;
    }

    /**
     *
     * @return integer|null
     */
    public function getContainerOutputItemId()
    {
        return $this->containerOutputItemId;
    }

    /**
     *
     * @return integer|null
     */
    public function getCraftingMaterialOutputItemId()
    {
        return $this->armorOutputItemId;
    }

    /**
     *
     * @return integer|null
     */
    public function getTrinketOutputItemId()
    {
        return $this->trinketOutputItemId;
    }

    /**
     *
     * @return integer|null
     */
    public function getUpgradeComponentOutputItemId()
    {
        return $this->upgradeComponentOutputItemId;
    }

    /**
     *
     * @return integer|null
     */
    public function getWeaponOutputItemId()
    {
        return $this->weaponOutputItemId;
    }
}

?>
