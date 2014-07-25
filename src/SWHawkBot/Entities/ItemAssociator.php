<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;
use SWHawkBot\Factories\ItemFactory;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
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
     * Instace de l'objet contenu dans ce conteneur
     *
     * @var SWHawkBot\Items\Item;
     */
    protected $realItem;

    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="outputItemAssociator")
     *
     * @var ArrayCollection[Recipe]
     */
    protected $recipes;

    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="mat1Associator")
     *
     * @var ArrayCollection[Recipe]
     */
    protected $mat1Recipes;

    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="mat2Associator")
     *
     * @var ArrayCollection[Recipe]
     */
    protected $mat2Recipes;

    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="mat3Associator")
     *
     * @var ArrayCollection[Recipe]
     */
    protected $mat3Recipes;

    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="mat4Associator")
     *
     * @var ArrayCollection[Recipe]
     */
    protected $mat4Recipes;

    /**
     * @ORM\OneToOne(targetEntity="Armor", inversedBy="associator", fetch="EAGER")
     *
     * @var Armor
     */
    protected $armorpiece;

    /**
     * @ORM\OneToOne(targetEntity="Back", inversedBy="associator", fetch="EAGER")
     *
     * @var Back
     */
    protected $back;

    /**
     * @ORM\OneToOne(targetEntity="Bag", inversedBy="associator", fetch="EAGER")
     *
     * @var Bag
     */
    protected $bag;

    /**
     * @ORM\OneToOne(targetEntity="Consumable", inversedBy="associator", fetch="EAGER")
     *
     * @var Consumable
     */
    protected $consumable;

    /**
     * @ORM\OneToOne(targetEntity="Container", inversedBy="associator", fetch="EAGER")
     *
     * @var Container
     */
    protected $container;

    /**
     * @ORM\OneToOne(targetEntity="CraftingMaterial", inversedBy="associator", fetch="EAGER")
     *
     * @var CraftingMaterial
     */
    protected $craftingMaterial;

    /**
     * @ORM\OneToOne(targetEntity="Gizmo", inversedBy="associator", fetch="EAGER")
     *
     * @var Gizmo
     */
    protected $gizmo;

    /**
     * @ORM\OneToOne(targetEntity="Trinket", inversedBy="associator", fetch="EAGER")
     *
     * @var Trinket
     */
    protected $trinket;

    /**
     * @ORM\OneToOne(targetEntity="Trophy", inversedBy="associator", fetch="EAGER")
     *
     * @var Trophy
     */
    protected $trophy;

    /**
     * @ORM\OneToOne(targetEntity="UpgradeComponent", inversedBy="associator", fetch="EAGER")
     *
     * @var UpgradeComponent
     */
    protected $upgradeComponent;

    /**
     * @ORM\OneToOne(targetEntity="Weapon", inversedBy="associator", fetch="EAGER")
     *
     * @var Weapon
     */
    protected $weapon;

    /**
     * Constructeur de l'objet, possiblement à partir d'un array
     * provenant de l'API GuildWars2
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
     *
     * @param Item $item
     * @return \SWHawkBot\Entities\ItemAssociator
     */
    public function setRealItem(Item $item)
    {
        $this->realItem = $item;
        return $this;
    }

    public function setGw2ApiId($id)
    {
        if (!is_int($id))
        {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : '.var_dump($id));
        }
        $this->gw2ApiId = $id;
        return $this;
    }

    public function setArmorpiece(Armor $armor)
    {
        $this->armorpiece = $armor;
        return $this->armorpiece;
    }

    public function setBack(Back $back)
    {
        $this->back = $back;
        return $this;
    }

    public function setBag(Bag $bag)
    {
        $this->bag = $bag;
        return $this;
    }

    public function setConsumable(Consumable $consumable)
    {
        $this->consumable = $consumable;
        return $this;
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }

    public function setCraftingMaterial(CraftingMaterial $material)
    {
        $this->craftingMaterial = $material;
        return $this;
    }

    public function setGuizmo(Gizmo $gizmo)
    {
        $this->gizmo = $gizmo;
        return $this;
    }

    public function setTrinket(Trinket $trinket)
    {
        $this->trinket = $trinket;
        return $this;
    }

    public function setTrophy(Trophy $trophy)
    {
        $this->trophy = $trophy;
        return $this;
    }

    public function setUpgradeComponent(UpgradeComponent $component)
    {
        $this->upgradeComponent = $component;
        return $this;
    }

    public function setWeapon(Weapon $weapon)
    {
        $this->weapon = $weapon;
        return $this;
    }

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
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getGw2ApiId()
    {
        return $this->gw2ApiId;
    }

    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     *
     * @return Recipe[]
     */
    public function getMat1Recipes()
    {
        return $this->mat1Recipes;
    }

    /**
     *
     * @return Recipe[]
     */
    public function getMat2Recipes()
    {
        return $this->mat2Recipes;
    }

    /**
     *
     * @return Recipe[]
     */
    public function getMat3Recipes()
    {
        return $this->mat3Recipes;
    }

    /**
     *
     * @return Recipe[]
     */
    public function getMat4Recipes()
    {
        return $this->mat4Recipes;
    }

    public function addRecipe(Recipe $recipe)
    {
        $this->recipes->add($recipe);
        return $this;
    }

    /**
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
     *
     * @param Recipe $recipe
     * @return ItemAssociator
     */
    public function addMat4Recipe(Recipe $recipe)
    {
        $this->mat4Recipes->add($recipe);
        return $this;
    }

    public function getArmorpiece()
    {
        return $this->armorpiece;
    }

    public function getBack()
    {
        return $this->back;
    }

    public function getBag()
    {
        return $this->bag;
    }

    public function getConsumable()
    {
        return $this->consumable;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getCraftingMaterial()
    {
        return $this->craftingMaterial;
    }

    public function getGizmo()
    {
        return $this->gizmo;
    }

    public function getTrinket()
    {
        return $this->trinket;
    }

    public function getTrophy()
    {
        return $this->trophy;
    }

    public function getUpgradeComponent()
    {
        return $this->upgradeComponent;
    }

    public function getWeapon()
    {
        return $this->weapon;
    }

    public function getRealItem()
    {
        if (is_null($this->realItem)) {
            $this->initRealItem();
        }
        return $this->realItem;
    }

}

?>
