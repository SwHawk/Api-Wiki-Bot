<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Factories\ItemFactory;
use SWHawkBot\Constants;

/**
 * Modèle de donnée des recettes d'artisanat de
 * GuildWars 2
 *
 * @author SwHawk
 *
 *         @ORM\Entity(repositoryClass="SWHawkBot\Entities\Repositories\RecipeRepository")
 *         @ORM\Table(name="Recipes")
 *         @ORM\EntityListeners({"SWHawkBot\Entities\Listeners\RecipeListener"})
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
    protected $gw2ApiId;

    /**
     * Type de la recette dans la discipline d'artisanat
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $type;

    /**
     * Identifiant Gw2ApiId de l'objet produit par la
     * recette
     *
     * @var int
     */
    protected $outputItemId;

    /**
     * @ORM\ManyToOne(targetEntity="ItemAssociator", inversedBy="recipes", cascade={"persist", "remove"})
     *
     * @var ItemAssociator
     */
    protected $outputItemAssociator;

    /**
     * Objet produit par la recette, mis en place
     * en postLoad
     *
     * @var Item
     */
    protected $outputItem;

    /**
     * Nombre d'objets produits par la recette
     *
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $outputItemCount;

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
     * ItemAssociator correspondant au premier ingrédient
     * de la recette
     *
     * @ORM\ManyToOne(targetEntity="ItemAssociator", inversedBy="mat1Recipes", cascade={"persist", "remove"})
     *
     * @var ItemAssociator
     */
    protected $mat1Associator;

    /**
     * Premier ingrédient de la recette
     *
     * @var Item
     */
    protected $mat1;

    /**
     * Identifiant auprès de l'API
     * GW2 du premier ingrédient de
     * la recette
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
     * ItemAssociator correspondant au deuxième ingrédient
     * de la recette
     *
     * @ORM\ManyToOne(targetEntity="ItemAssociator", inversedBy="mat2Recipes", cascade={"persist", "remove"})
     *
     * @var integer|null
     */
    protected $mat2Associator = null;

    /**
     * Premier ingrédient de la recette
     *
     * @var Item
     */
    protected $mat2;

    /**
     * Identifiant auprès de l'API
     * GW2 du second ingrédient de
     * la recette
     *
     * @var integer
     */
    protected $mat2Id;

    /**
     * Quantité nécessaire du deuxième ingrédient
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $mat2Qty = null;

    /**
     * ItemAssociator correspondant au troisième ingrédient
     * de la recette
     *
     * @ORM\ManyToOne(targetEntity="ItemAssociator", inversedBy="mat3Recipes", cascade={"persist", "remove"})
     *
     * @var integer|null
     */
    protected $mat3Associator = null;

    /**
     * Premier ingrédient de la recette
     *
     * @var Item
     */
    protected $mat3;

    /**
     * Identifiant auprès de l'API
     * GW2 du troisième ingrédient de
     * la recette
     *
     * @var integer
     */
    protected $mat3Id;

    /**
     * Quantité nécessaire du troisième ingrédient
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $mat3Qty = null;

    /**
     * ItemAssociator correspondant au quatrième ingrédient
     * de la recette
     *
     * @ORM\ManyToOne(targetEntity="ItemAssociator", inversedBy="mat4Recipes", cascade={"persist", "remove"})
     *
     * @var integer|null
     */
    protected $mat4Associator = null;

    /**
     * Premier ingrédient de la recette
     *
     * @var Item
     */
    protected $mat4;

    /**
     * Identifiant auprès de l'API
     * GW2 du quatrième ingrédient de
     * la recette
     *
     * @var integer
     */
    protected $mat4Id;

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
            $this->setGw2ApiId($recipe['recipe_id']);
        }

        if (isset($recipe['type'])) {
            $this->setType($recipe['type']);
        }

        if (isset($recipe['output_item_id'])) {
            $this->setOutputItemId((int) $recipe['output_item_id']);
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
            $this->setDiscovery($recipe['flags'][0], $this->getType());
        } else {
            $this->setDiscovery(null, $this->getType());
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
     * Définit l'identifiant de la recette auprès
     * de l'API GW2
     *
     * @param integer $id
     * @throws \InvalidArgumentException
     * @return Recipe
     */
    public function setGw2ApiId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->gw2ApiId = $id;
        return $this;
    }

    /**
     * Définit le type de la recette
     *
     * @param string $type
     * @return Recipe
     */
    public function setType($type)
    {
        if (array_key_exists($type, Constants::$translation['recipe_types']))
        {
            $this->type = Constants::$translation['recipe_types'][$type];
            return $this;
        }
        $this->type = $type;
        return $this;
    }



    /**
     * Définit l'identifiant auprès de l'API
     * GW2 du produit de la recette
     *
     * @param integer $id
     * @return \SWHawkBot\Entities\Recipe
     */
    public function setOutputItemId($id)
    {
        if (!is_int($id))
        {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : '.var_dump($id));
        }
        $this->outputItemId = $id;
        return $this;
    }

    /**
     * Définit l'associator de l'objet produit
     * par la recette
     *
     * @param ItemAssociator $associator
     * @return Recipe
     */
    public function setOutputItemAssociator(ItemAssociator $associator)
    {
        $this->outputItemAssociator = $associator;
        return $this;
    }

    /**
     * Définit le raccourci vers l'objet
     * produit
     *
     * @param Item $item
     * @return Recipe
     */
    public function setOutputItem(Item $item)
    {
        $this->outputItem = $item;
        return $this;
    }

    /**
     * Définit le nombre d'objets produits
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
        $this->outputItemCount = $count;
        return $this;
    }

    /**
     * Définit la difficulté de la recette
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
     * Définit le type de découverte de la
     * recette
     *
     * @param string $type
     * @param string $discovery
     * @return Recipe
     */
    public function setDiscovery($type, $discovery = null)
    {
        if ($discovery == Constants::$translation['recipe_discovery']['API_strings']['APIAutoLearned']) {
            $this->discovery = Constants::$translation['recipe_discovery'][$discovery];
            return $this;
        }
        if ($discovery == Constants::$translation['recipe_discovery']['API_strings']['APILearnedFromItem']) {
            if ($type == Constants::$translation['recipe_types']['Bulk'] ||
                $type == Constants::$translation['recipe_types']['Feast']) {
                $this->discovery = Constants::$translation['recipe_discovery']['Mystical'];
                return $this;
            } else {
                $this->discovery = Constants::$translation['recipe_discovery'][$discovery];
                return $this;
            }
        } else {
            $this->discovery = Constants::$translation['recipe_discovery']['Discovered'];
            return $this;
        }
    }

    /**
     * Définit l'identifiant auprès de l'API
     * GW2 du premier ingrédient de la recette
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
     * Définit l'associator du premier ingrédient
     * de la recette
     *
     * @param ItemAssociator $associator
     * @return Recipe
     */
    public function setMat1Associator(ItemAssociator $associator)
    {
        $this->mat1Associator = $associator;
        return $this;
    }

    /**
     * Définit le raccourci vers le premier
     * ingrédient de la recette
     *
     * @param Item $ingredient
     * @return Recipe
     */
    public function setMat1(Item $ingredient)
    {
        $this->mat1 = $ingredient;
        return $this;
    }

    /**
     * Définit la quantité nécessaire en
     * premier ingrédient
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
     * Définit l'identifiant auprès de l'API
     * GW2 du second ingrédient de la recette
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
     * Définit l'associator du second ingrédient
     * de la recette
     *
     * @param ItemAssociator $associator
     * @return Recipe
     */
    public function setMat2Associator(ItemAssociator $associator)
    {
        $this->mat2Associator = $associator;
        return $this;
    }

    /**
     * Définit le raccourci vers le second
     * ingrédient de la recette
     *
     * @param Item $ingredient
     * @return Recipe
     */
    public function setMat2(Item $ingredient)
    {
        $this->mat2 = $ingredient;
        return $this;
    }

    /**
     * Définit la quantité nécessaire en
     * second ingrédient
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
     * Définit l'identifiant auprès de l'API
     * GW2 du troisième ingrédient de la recette
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
     * Définit l'associator du troisième ingrédient
     * de la recette
     *
     * @param ItemAssociator $associator
     * @return Recipe
     */
    public function setMat3Associator(ItemAssociator $associator)
    {
        $this->mat3Associator = $associator;
        return $this;
    }

    /**
     * Définit le raccourci vers le troisième
     * ingrédient de la recette
     *
     * @param Item $ingredient
     * @return Recipe
     */
    public function setMat3(Item $ingredient)
    {
        $this->mat3 = $ingredient;
        return $this;
    }

    /**
     * Définit la quantité nécessaire en
     * troisième ingrédient
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
     * Définit l'identifiant auprès de l'API
     * GW2 du quatrième ingrédient de la recette
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
     * Définit l'associator du quatrième ingrédient
     * de la recette
     *
     * @param ItemAssociator $associator
     * @return Recipe
     */
    public function setMat4Associator(ItemAssociator $associator)
    {
        $this->mat4Associator = $associator;
        return $this;
    }

    /**
     * Définit le raccourci vers le premier
     * ingrédient de la recette
     *
     * @param Item $ingredient
     * @return Recipe
     */
    public function setMat4(Item $ingredient)
    {
        $this->mat4 = $ingredient;
        return $this;
    }

    /**
     * Définit la quantité nécessaire en
     * quatrième ingrédient
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
     * Définit les disciplines d'artisanat
     * de la recette
     *
     * @param array $disciplines
     * @return Recipe
     */
    public function setDisciplines($disciplines)
    {
        foreach ($disciplines as &$discipline) {
            if (array_key_exists($discipline, Constants::$translation['crafting_disciplines']))
            {
                $discipline = Constants::$translation['crafting_disciplines'][$discipline];
            }
        }
        $this->disciplines = implode(", ", $disciplines);
        return $this;
    }

    /**
     * Retourne l'identifiant de la recette
     * en base de données
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retourne l'identifiant de la recette
     * auprès de l'API GW2
     *
     * @return integer
     */
    public function getGw2ApiId()
    {
        return $this->gw2ApiId;
    }

    /**
     * Retourne le type de la recette
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Retourne l'identifiant auprès de l'API
     * GW2 de la recette
     *
     * @return integer
     */
    public function getOutputItemId()
    {
        return $this->outputItemId;
    }

    /**
     * Retourne l'associator de l'objet produit
     * par la recette
     *
     * @return \SWHawkBot\Entities\ItemAssociator
     */
    public function getOutputItemAssociator()
    {
        return $this->outputItemAssociator;
    }

    /**
     * Retourne l'objet produit par la recette, et
     * l'initialise au besoin
     *
     * @return \SWHawkBot\Entities\Item
     */
    public function getOutputItem()
    {
        if(is_null($this->outputItem)) {
            $this->initOutputItem();
        }
        return $this->outputItem;
    }

    /**
     * Retourne le nombre d'objets produits
     * par la recette
     *
     * @return integer
     */
    public function getOutputItemCount()
    {
        return $this->outputItemCount;
    }

    /**
     * Retourne la difficulté de la recette
     *
     * @return integer
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Retourne les disciplines d'artisanat
     * de la recette
     *
     * @return string
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }

    /**
     * Retourne l'identifiant auprès de l'API
     * GW2 du premier ingrédient de la recette
     *
     * @return integer
     */
    public function getMat1Id()
    {
        return $this->mat1Id;
    }

    /**
     * Retourne l'associator du premier
     * ingrédient de la recette
     *
     * @return ItemAssociator
     */
    public function getMat1Associator()
    {
        return $this->mat1Associator;
    }

    /**
     * Retourne le premier ingrédient de
     * la recette et l'initialise au besoin
     *
     * @return Item
     */
    public function getMat1()
    {
        if (is_null($this->mat1))
        {
            $this->initMat1();
        }
        return $this->mat1;
    }

    /**
     * Initialise le raccourci vers le
     * premier ingrédient de la recette
     */
    private function initMat1()
    {
        $this->mat1 = $this->getMat1Associator()->getRealItem();
    }

    /**
     * Renvoie la quantité nécessaire en
     * premier ingrédient
     *
     * @return integer
     */
    public function getMat1Qty()
    {
        return $this->mat1Qty;
    }

    /**
     * Retourne l'identifiant auprès de l'API
     * GW2 du second ingrédient de la recette
     *
     * @return integer|null
     */
    public function getMat2Id()
    {
        return $this->mat2Id;
    }

    /**
     * Retourne l'associator du second
     * ingrédient de la recette
     *
     * @return ItemAssociator
     */
    public function getMat2Associator()
    {
        return $this->mat2Associator;
    }

    /**
     * Retourne le second ingrédient de
     * la recette et l'initialise au besoin
     *
     * @return Item
     */
    public function getMat2()
    {
        if ((! is_null($this->getMat2Associator())) && is_null($this->mat2))
        {
            $this->initMat2();
        }
        return $this->mat2;
    }

    /**
     * Initialise le raccourci vers le
     * second ingrédient de la recette
     */
    private function initMat2()
    {
        $this->mat2 = $this->getMat2Associator()->getRealItem();
    }

    /**
     * Renvoie la quantité nécessaire en
     * second ingrédient
     *
     * @return integer|null
     */
    public function getMat2Qty()
    {
        return $this->mat2Qty;
    }

    /**
     * Retourne l'identifiant auprès de l'API
     * GW2 du troisième ingrédient de la recette
     *
     * @return integer|null
     */
    public function getMat3Id()
    {
        return $this->mat3Id;
    }

    /**
     * Retourne l'associator du troisième
     * ingrédient de la recette
     *
     * @return ItemAssociator
     */
    public function getMat3Associator()
    {
        return $this->mat3Associator;
    }

    /**
     * Retourne le troisième ingrédient de
     * la recette et l'initialise au besoin
     *
     * @return Item
     */
    public function getMat3()
    {
        if ((! is_null($this->getMat3Associator())) && is_null($this->mat3))
        {
            $this->initMat3();
        }
        return $this->mat3;
    }

    /**
     * Initialise le raccourci vers le
     * troisième ingrédient de la recette
     */
    private function initMat3()
    {
        $this->mat3 = $this->getMat3Associator()->getRealItem();
    }

    /**
     * Renvoie la quantité nécessaire en
     * troisième ingrédient
     *
     * @return integer|null
     */
    public function getMat3Qty()
    {
        return $this->mat3Qty;
    }

    /**
     * Retourne l'identifiant auprès de l'API
     * GW2 du quatrième ingrédient de la recette
     *
     * @return integer|null
     */
    public function getMat4Id()
    {
        return $this->mat4Id;
    }

    /**
     * Retourne l'associator du quatrième
     * ingrédient de la recette
     *
     * @return ItemAssociator
     */
    public function getMat4Associator()
    {
        return $this->mat4Associator;
    }
    /**
     * Retourne le quatrième ingrédient de
     * la recette et l'initialise au besoin
     *
     * @return Item
     */
    public function getMat4()
    {
        if ((! is_null($this->getMat4Associator())) && is_null($this->mat4))
        {
            $this->initMat4();
        }
        return $this->mat4;
    }

    /**
     * Initialise le raccourci vers le
     * quatrième ingrédient de la recette
     */
    private function initMat4()
    {
        $this->mat4 = $this->getMat4Associator()->getRealItem();
    }

    /**
     * Renvoie la quantité nécessaire en
     * quatrième ingrédient
     *
     * @return integer|null
     */
    public function getMat4Qty()
    {
        return $this->mat4Qty;
    }

    /**
     * Renvoie la méthode de dévouverte
     * de la recette
     *
     * @return string
     */
    public function getDiscovery()
    {
        return $this->discovery;
    }
}

?>
