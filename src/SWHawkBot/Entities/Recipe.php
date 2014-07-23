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
 *         @ORM\Entity
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
     * Identifiant Gw2ApiId de l'objet produit par la
     * recette
     *
     * @var int
     */
    protected $outputItemId;

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
     * @ORM\ManyToOne(targetEntity="ItemAssociator", cascade={"persist", "remove"})
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
     * @ORM\ManyToOne(targetEntity="ItemAssociator", cascade={"persist", "remove"})
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
     * @ORM\ManyToOne(targetEntity="ItemAssociator", cascade={"persist", "remove"})
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
     * @ORM\ManyToOne(targetEntity="ItemAssociator", cascade={"persist", "remove"})
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
            $this->setGw2apiId($recipe['recipe_id']);
        }

        if (isset($recipe['type'])) {
            $this->setType($recipe['type']);
        }

        if (isset($recipe['output_item_id'], $recipe['type'])) {
            $this->setOutputItem($recipe['output_item_id']);
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
        if (array_key_exists($type, Constants::$translation['recipe_types']))
        {
            $this->type = Constants::$translation['recipe_types'][$type];
            return $this;
        }
        $this->type = $type;
        return $this;
    }



    /**
     *
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
     * @param ItemAssociator $associator
     * @return Recipe
     */
    public function setMat1Associator(ItemAssociator $associator)
    {
        $this->mat1Associator = $associator;
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
     * @param ItemAssociator $associator
     * @return Recipe
     */
    public function setMat2Associator(ItemAssociator $associator)
    {
        $this->mat2Associator = $associator;
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
     * @param ItemAssociator $associator
     * @return Recipe
     */
    public function setMat3Associator(ItemAssociator $associator)
    {
        $this->mat3Associator = $associator;
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
     * @param ItemAssociator $associator
     * @return Recipe
     */
    public function setMat4Associator(ItemAssociator $associator)
    {
        $this->mat4Associator = $associator;
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
            if (array_key_exists($discipline, Constants::$translation['crafting_disciplines']))
            {
                $discipline = Constants::$translation['crafting_disciplines'][$discipline];
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

    public function getOutputItemId()
    {
        return $this->outputItemId;
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


}

?>
