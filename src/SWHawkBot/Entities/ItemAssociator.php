<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;
use SWHawkBot\Factories\ItemFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;

/**
 * Classe permettant l'association entre les recettes
 * et les différents types d'objets
 *
 * @author SwHawk
 *
 *         @ORM\Entity
 *         @ORM\Table(name="Items")
 */
class ItemAssociator
{

    /**
     * Identifiant de l'objet en BDD
     *
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * Identifiant de l'objet auprès de l'API GW2
     *
     * @ORM\Column(type="integer", unique=true, nullable=false)
     *
     * @var int
     */
    protected $gw2ApiId;

    /**
     * Nom de l'objet associé
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $itemName;


    /**
     * Rareté de l'objet associé
     *
     * @ORM\Column(type="rarityenum")
     *
     * @var string
     */
    protected $itemRarity;

    /**
     * Niveau de l'objet associé
     *
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $itemLevel;

    /**
     * Raccourci vers l'objet associé
     *
     * @var Item;
     */
    protected $realItem;

    /**
     * Collection des recettes permettant de produire
     * l'objet associé
     *
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="outputItemAssociator")
     *
     * @var ArrayCollection[Recipe]
     */
    protected $recipes;

    /**
     * Collection des recettes ayant l'objet associé
     * comme premier ingrédient
     *
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="mat1Associator")
     *
     * @var ArrayCollection[Recipe]
     */
    protected $mat1Recipes;

    /**
     * Collection des recettes ayant l'objet associé
     * comme deuxième ingrédient
     *
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="mat2Associator")
     *
     * @var ArrayCollection[Recipe]
     */
    protected $mat2Recipes;

    /**
     * Collection des recettes ayant l'objet associé
     * comme troisième ingrédient
     *
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="mat3Associator")
     *
     * @var ArrayCollection[Recipe]
     */
    protected $mat3Recipes;

    /**
     * Collection des recettes ayant l'objet associé
     * comme quatrième ingrédient
     *
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="mat4Associator")
     *
     * @var ArrayCollection[Recipe]
     */
    protected $mat4Recipes;

    /**
     * Pièce d'armure associée
     *
     * @ORM\OneToOne(targetEntity="Armor", inversedBy="associator", fetch="EAGER")
     *
     * @var Armor
     */
    protected $armorpiece;

    /**
     * Sac à dos associé
     *
     * @ORM\OneToOne(targetEntity="Back", inversedBy="associator", fetch="EAGER")
     *
     * @var Back
     */
    protected $back;

    /**
     * Sac associé
     *
     * @ORM\OneToOne(targetEntity="Bag", inversedBy="associator", fetch="EAGER")
     *
     * @var Bag
     */
    protected $bag;

    /**
     * Consommable associé
     *
     * @ORM\OneToOne(targetEntity="Consumable", inversedBy="associator", fetch="EAGER")
     *
     * @var Consumable
     */
    protected $consumable;

    /**
     * Conteneur associé
     *
     * @ORM\OneToOne(targetEntity="Container", inversedBy="associator", fetch="EAGER")
     *
     * @var Container
     */
    protected $container;

    /**
     * Matériau d'artisanat associé
     *
     * @ORM\OneToOne(targetEntity="CraftingMaterial", inversedBy="associator", fetch="EAGER")
     *
     * @var CraftingMaterial
     */
    protected $craftingMaterial;

    /**
     * Gizmo associé
     *
     * @ORM\OneToOne(targetEntity="Gizmo", inversedBy="associator", fetch="EAGER")
     *
     * @var Gizmo
     */
    protected $gizmo;

    /**
     * Accessoire associé
     *
     * @ORM\OneToOne(targetEntity="Trinket", inversedBy="associator", fetch="EAGER")
     *
     * @var Trinket
     */
    protected $trinket;

    /**
     * Trophée associé
     *
     * @ORM\OneToOne(targetEntity="Trophy", inversedBy="associator", fetch="EAGER")
     *
     * @var Trophy
     */
    protected $trophy;

    /**
     * Composant d'amélioration associé
     *
     * @ORM\OneToOne(targetEntity="UpgradeComponent", inversedBy="associator", fetch="EAGER")
     *
     * @var UpgradeComponent
     */
    protected $upgradeComponent;

    /**
     * Arme associée
     *
     * @ORM\OneToOne(targetEntity="Weapon", inversedBy="associator", fetch="EAGER")
     *
     * @var Weapon
     */
    protected $weapon;

    /**
     * Constructeur de l'objet, à partir d'une
     * instance d'un objet du modèle de données
     *
     * @param array $item|null
     * @return Item
     */
    public function __construct(Item $item = null)
    {
        $this->recipes = new ArrayCollection();
        $this->mat1Recipes = new ArrayCollection();
        $this->mat2Recipes = new ArrayCollection();
        $this->mat3Recipes = new ArrayCollection();
        $this->mat4Recipes = new ArrayCollection();

        if (is_null($item)) {
            return $this;
        }

        $this->setGw2ApiId($item->getGw2ApiId());
        $this->setItemName($item->getName());
        $this->setItemRarity($item->getRarity());
        $this->setItemLevel($item->getLevel());

        if ($item instanceof Armor)
        {
            $this->setArmorpiece($item);
        }

        if ($item instanceof Back)
        {
            $this->setBack($item);
        }

        if ($item instanceof Bag)
        {
            $this->setBag($item);
        }

        if ($item instanceof Consumable)
        {
            $this->setConsumable($item);
        }

        if ($item instanceof Container)
        {
            $this->setContainer($item);
        }

        if ($item instanceof CraftingMaterial)
        {
            $this->setCraftingMaterial($item);
        }

        if ($item instanceof Gizmo)
        {
            $this->setGizmo($item);
        }

        if ($item instanceof Trinket)
        {
            $this->setTrinket($item);
        }

        if ($item instanceof Trophy)
        {
            $this->setTrophy($item);
        }

        if ($item instanceof UpgradeComponent)
        {
            $this->setUpgradeComponent($item);
        }

        if ($item instanceof Weapon)
        {
            $this->setWeapon($item);
        }

        $this->setRealItem($item);

        return $this;
    }

    /**
     * Définit l'objet associé
     *
     * @param Item $item
     * @return \SWHawkBot\Entities\ItemAssociator
     */
    public function setRealItem(Item $item)
    {
        $this->realItem = $item;
        return $this;
    }

    /**
     * Définit l'identifiant auprès de l'API GW2
     * de l'objet associé
     *
     * @param integer $id
     * @throws \InvalidArgumentException
     * @return ItemAssociator
     */
    public function setGw2ApiId($id)
    {
        if (!is_int($id))
        {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : '.var_dump($id));
        }
        $this->gw2ApiId = $id;
        return $this;
    }

    /**
     * Définit le nom de l'objet associé
     *
     * @param string $name
     * @return ItemAssociator
     */
    public function setItemName($name)
    {
        $this->itemName = $name;
        return $this;
    }

    /**
     * Définit la rareté de l'objet associé
     *
     * @param string $rarity
     * @return ItemAssociator
     */
    public function setItemRarity($rarity)
    {
        if (array_key_exists($rarity, Constants::$translation['rarity'])) {
            $this->itemRarity = Constants::$translation['rarity'][$rarity];
            return $this;
        } elseif(in_array($rarity, Constants::$translation['rarity'])) {
            $this->itemRarity = $rarity;
            return $this;
        }
    }

    /**
     * Définit le niveau nécessaire pour
     * l'objet associé
     *
     * @param integer $level
     * @throws \InvalidArgumentException
     * @return ItemAssociator
     */
    public function setItemLevel($level)
    {
        if (!is_numeric($level)) {
            throw new \InvalidArgumentException("La fonction attend un niveau entier. Niveau donné :".var_dump($level));
        }
        $this->itemLevel = $level;
        return $this;
    }

    /**
     * Définit la pièce d'armure associée
     *
     * @param Armor $armor
     * @return ItemAssociator
     */
    public function setArmorpiece(Armor $armor)
    {
        $this->armorpiece = $armor;
        return $this;
    }

    /**
     * Définit le sac à dos associé
     *
     * @param Back $back
     * @return ItemAssociator
     */
    public function setBack(Back $back)
    {
        $this->back = $back;
        return $this;
    }

    /**
     * Définit le sac associé
     *
     * @param Bag $bag
     * @return ItemAssociator
     */
    public function setBag(Bag $bag)
    {
        $this->bag = $bag;
        return $this;
    }

    /**
     * Définit le consommable associé
     *
     * @param Consumable $consumable
     * @return ItemAssociator
     */
    public function setConsumable(Consumable $consumable)
    {
        $this->consumable = $consumable;
        return $this;
    }

    /**
     * Définit le conteneur associé
     *
     * @param Container $container
     * @return \SWHawkBot\Entities\ItemAssociator
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * Définit le matériau d'artisanat associé
     *
     * @param CraftingMaterial $material
     * @return ItemAssociator
     */
    public function setCraftingMaterial(CraftingMaterial $material)
    {
        $this->craftingMaterial = $material;
        return $this;
    }

    /**
     * Définit le gizmo associé
     *
     * @param Gizmo $gizmo
     * @return \SWHawkBot\Entities\ItemAssociator
     */
    public function setGizmo(Gizmo $gizmo)
    {
        $this->gizmo = $gizmo;
        return $this;
    }

    /**
     * Définit l'accessoire associé
     *
     * @param Trinket $trinket
     * @return ItemAssociator
     */
    public function setTrinket(Trinket $trinket)
    {
        $this->trinket = $trinket;
        return $this;
    }

    /**
     * Définit le trophée associé
     *
     * @param Trophy $trophy
     * @return ItemAssociator
     */
    public function setTrophy(Trophy $trophy)
    {
        $this->trophy = $trophy;
        return $this;
    }

    /**
     * Définit le composant d'amélioration associé
     *
     * @param UpgradeComponent $component
     * @return \SWHawkBot\Entities\ItemAssociator
     */
    public function setUpgradeComponent(UpgradeComponent $component)
    {
        $this->upgradeComponent = $component;
        return $this;
    }

    /**
     * Définit l'arme associée
     *
     * @param Weapon $weapon
     * @return \SWHawkBot\Entities\ItemAssociator
     */
    public function setWeapon(Weapon $weapon)
    {
        $this->weapon = $weapon;
        return $this;
    }

    /**
     * Initialise le raccourci vers l'objet
     * associé
     */
    private function initRealItem()
    {
        if (!is_null($this->getArmorpiece())) {
            $this->setRealItem($this->getArmorpiece());
        }

        if (!is_null($this->getBack())) {
            $this->setRealItem($this->getBack());
        }

        if (!is_null($this->getBag())) {
            $this->setRealItem($this->getBag());
        }

        if (!is_null($this->getConsumable())) {
            $this->setRealItem($this->getConsumable());
        }

        if (!is_null($this->getContainer())) {
            $this->setRealItem($this->getContainer());
        }

        if (!is_null($this->getCraftingMaterial())) {
            $this->setRealItem($this->getCraftingMaterial());
        }

        if (!is_null($this->getGizmo())) {
            $this->setRealItem($this->getGizmo());
        }

        if (!is_null($this->getTrinket())) {
            $this->setRealItem($this->getTrinket());
        }

        if (!is_null($this->getTrophy())) {
            $this->setRealItem($this->getTrophy());
        }

        if (!is_null($this->getUpgradeComponent())) {
            $this->setRealItem($this->getUpgradeComponent());
        }

        if (!is_null($this->getWeapon())) {
            $this->setRealItem($this->getWeapon());
        }
    }

    /**
     * Retourne l'identifiant de l'associator
     * en base de données
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retourne l'identifiant de l'objet
     * associé auprès de l'API GW2
     *
     * @return number
     */
    public function getGw2ApiId()
    {
        return $this->gw2ApiId;
    }

    /**
     * Retourne le nom de l'objet associé
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->itemName;
    }


    /**
     * Retourne la rareté de l'objet associé
     *
     * @return string
     */
    public function getItemRarity()
    {
        return $this->itemRarity;
    }

    /**
     * Retourne le niveau nécessaire
     * pour l'objet associé
     *
     * @return integer
     */
    public function getItemLevel()
    {
        return $this->itemLevel;
    }

    /**
     * Retourne la collection de recettes
     * permettant de produire l'objet
     * associé
     *
     * @return ArrayCollection[Recipe]
     */
    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     * Retourne la collection de recettes
     * ayant l'objet associé comme premier
     * ingrédient
     *
     * @return Recipe[]
     */
    public function getMat1Recipes()
    {
        return $this->mat1Recipes;
    }

    /**
     * Retourne la collection de recettes
     * ayant l'objet associé comme second
     * ingrédient
     *
     * @return Recipe[]
     */
    public function getMat2Recipes()
    {
        return $this->mat2Recipes;
    }

    /**
     * Retourne la collection de recettes
     * ayant l'objet associé comme troisième
     * ingrédient
     *
     * @return Recipe[]
     */
    public function getMat3Recipes()
    {
        return $this->mat3Recipes;
    }

    /**
     * Retourne la collection de recettes
     * ayant l'objet associé comme quatrième
     * ingrédient
     *
     * @return Recipe[]
     */
    public function getMat4Recipes()
    {
        return $this->mat4Recipes;
    }

    /**
     * Ajoute une recette à la collection des
     * recettes permettant de produire l'objet
     * associé
     *
     * @param Recipe $recipe
     * @return \SWHawkBot\Entities\ItemAssociator
     */
    public function addRecipe(Recipe $recipe)
    {
        $this->recipes->add($recipe);
        return $this;
    }

    /**
     * Ajoute une recette à la collection des
     * recettant ayant l'objet associé comme
     * premier ingrédient
     *
     * @param Recipe $recipe
     * @return ItemAssociator
     */
    public function addMat1Recipe(Recipe $recipe)
    {
        $this->mat1Recipes->add($recipe);
        return $this;
    }

    /**
     * Ajoute une recette à la collection des
     * recettant ayant l'objet associé comme
     * second ingrédient
     *
     * @param Recipe $recipe
     * @return ItemAssociator
     */
    public function addMat2Recipe(Recipe $recipe)
    {
        $this->mat2Recipes->add($recipe);
        return $this;
    }

    /**
     * Ajoute une recette à la collection des
     * recettant ayant l'objet associé comme
     * troisième ingrédient
     *
     * @param Recipe $recipe
     * @return ItemAssociator
     */
    public function addMat3Recipe(Recipe $recipe)
    {
        $this->mat3Recipes->add($recipe);
        return $this;
    }

    /**
     * Ajoute une recette à la collection des
     * recettant ayant l'objet associé comme
     * quatrième ingrédient
     *
     * @param Recipe $recipe
     * @return ItemAssociator
     */
    public function addMat4Recipe(Recipe $recipe)
    {
        $this->mat4Recipes->add($recipe);
        return $this;
    }

    /**
     * Retourne la pièce d'amure associée
     *
     * @return Armor
     */
    public function getArmorpiece()
    {
        return $this->armorpiece;
    }

    /**
     * Retourne le sac à dos associé
     *
     * @return Back
     */
    public function getBack()
    {
        return $this->back;
    }

    /**
     * Retourne le sac associé
     *
     * @return Bag
     */
    public function getBag()
    {
        return $this->bag;
    }

    /**
     * Retourne le consommable associé
     *
     * @return Consumable
     */
    public function getConsumable()
    {
        return $this->consumable;
    }

    /**
     * Retourne le conteneur associé
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Retourne le matériau d'artisanat
     * associé
     *
     * @return CraftingMaterial
     */
    public function getCraftingMaterial()
    {
        return $this->craftingMaterial;
    }

    /**
     * Retourne le Gizmo associé
     *
     * @return Gizmo
     */
    public function getGizmo()
    {
        return $this->gizmo;
    }

    /**
     * Retourne l'accessoire associé
     *
     * @return Trinket
     */
    public function getTrinket()
    {
        return $this->trinket;
    }

    /**
     * Retourne le trophée associé
     *
     * @return Trophy
     */
    public function getTrophy()
    {
        return $this->trophy;
    }

    /**
     * Renvoie le composant d'artisanat associé
     *
     * @return UpgradeComponent
     */
    public function getUpgradeComponent()
    {
        return $this->upgradeComponent;
    }

    /**
     * Renvoie l'arme associée
     *
     * @return Weapon
     */
    public function getWeapon()
    {
        return $this->weapon;
    }

    /**
     * Renvoie le raccourci vers l'objet associé
     * et l'initialise si nécessaire
     *
     * @return Item;
     */
    public function getRealItem()
    {
        if (is_null($this->realItem)) {
            $this->initRealItem();
        }
        return $this->realItem;
    }

}

?>
