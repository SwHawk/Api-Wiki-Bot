<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cette classe *abstraite* représente un objet quelconque du jeu.
 * Elle n'est pas censée être utilisée car tout objet de la classe **Item**
 * ne sera pas persisté en base de donnée
 *
 * @author SwHawk
 *
 *         @ORM\MappedSuperClass
 *
 */
class Item
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
     * Identifiant de l'objet dans l'API GuildWars2
     *
     * @ORM\Column(type="integer", unique=true)
     *
     * @var int
     */
    protected $gw2ApiId;

    /**
     * Nom de l'objet en jeu
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $name;

    /**
     * Description de l'objet
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $description;

    /**
     * Type de l'objet.
     *
     * Par exemple : Consommable, Espadon, Teinture, etc...
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $type;

    /**
     * Niveau nécessaire pour l'objet
     *
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $level;

    /**
     * Rareté de l'objet
     *
     * Valeurs possibles : Déchet, Simple, Raffiné, Chef d'oeuvre, Rare,
     * Exotique, Elevé, Légendaire
     *
     * @ORM\Column(type="rarityenum")
     *
     * @var string
     */
    protected $rarity;

    /**
     * Valeur de l'objet auprès d'un marchand
     *
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $vendor_value;

    /**
     * Liaison au compte de l'objet
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $soulbind;

    /**
     * Liaison à l'âme de l'objet
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $accountbind;

    /**
     * Recettes permettant de produire l'objet,
     * initialisé par le listener
     *
     * @var ArrayCollection(Recipe)
     */
    protected $recipes;

    /**
     * Associator de l'objet. Utilisé pour faire les liaisons
     * entre les recettes et les différentes classes d'objets
     *
     * @ORM\OneToOne(targetEntity="ItemAssociator")
     *
     * @var ItemAssociator
     */
    protected $associator;

    /**
     * Identifiant de l'icône de l'objet pour l'API de rendu de GuildWars2
     *
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $iconFileId;

    /**
     * Signature de l'îcone de l'objet pour l'API de rendu de GuildWars2
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $iconFileSignature;

    /**
     * Tableau JSON de l'objet renvoyé par l'API
     *
     * @ORM\Column(type="array")
     *
     * @var array
     */
    protected $itemRaw;

    /**
     * Ensemble des recettes dans lesquelles cet objet
     * est un ingrédient. Rempli depuis l'associator
     * de l'objet
     *
     * @var ArrayCollection(Recipe)
     */
    protected $recipesUsedIn;

    /**
     * Constructeur de l'objet, possiblement à partir d'un array
     * provenant de l'API GuildWars2
     *
     * @param array $item|null
     * @return Item
     */
    public function __construct($item = null)
    {
        $this->recipesUsedIn = new ArrayCollection();
        $this->recipes = new ArrayCollection();

        if (is_null($item)) {
            return $this;
        }

        if (isset($item['item_id'])) {
            $this->setGw2ApiId((int) $item['item_id']);
        }
        if (isset($item['name'])) {
            $this->setName($item['name']);
        }
        if (isset($item['description'])) {
            $this->setDescription($item['description']);
        }
        if (isset($item['type'])) {
            $this->setType($item['type']);
        }
        if (isset($item['level'])) {
            $this->setLevel($item['level']);
        }
        if (isset($item['rarity'])) {
            $this->setRarity($item['rarity']);
        }
        if (isset($item['vendor_value'])) {
            $this->setVendorValue($item['vendor_value']);
        }
        if (isset($item['flags'][0])) {
            foreach ($item['flags'] as $flag) {
                if (array_key_exists($flag, Constants::$translation['item_flags']['soul_binding'])) {
                    $this->setSoulbind($flag);
                } elseif (array_key_exists($flag, Constants::$translation['item_flags']['account_binding'])) {
                    $this->setAccountbind($flag);
                }
            }
        }

        if (isset($item['icon_file_id'])) {
            $this->setIconFileId($item['icon_file_id']);
            $this->setIconFileSignature($item['icon_file_signature']);
        }

        $this->itemRaw = $item;
        return $this;
    }

    /**
     * Définit l'identifiant de l'objet auprès
     * de l'API de GW2
     *
     * @param int $id
     * @throws \InvalidArgumentException
     * @return Item
     */
    public function setGw2ApiId($id)
    {
        if (! is_int($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->gw2ApiId = $id;
        return $this;
    }

    /**
     * Définit le nom de l'objet
     *
     * @param string $name
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Définit la description de l'objet
     *
     * @param string $description
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Définit le type de l'objet, destiné
     * à être surchargé par les classes filles
     *
     * @param string $type
     * @return Item
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Définit le niveau minimum pour pouvoir
     * utiliser l'objet
     *
     * @param int $level
     * @throws \InvalidArgumentException
     * @return Item
     */
    public function setLevel($level)
    {
        if (! is_numeric($level)) {
            throw new \InvalidArgumentException('La fonction attend un level entier. Level donné : ' . var_dump($level));
        }
        $this->level = $level;
        return $this;
    }

    /**
     * Définit la rareté de l'objet, peut la traduire
     * depuis la rareté renvoyée par l'API
     *
     * @param string $rarity
     * @return Item
     */
    public function setRarity($rarity)
    {
        if (array_key_exists($rarity, Constants::$translation['rarity'])) {
            $this->rarity = Constants::$translation['rarity'][$rarity];
            return $this;
        } elseif(in_array($rarity, Constants::$translation['rarity'])) {
            $this->rarity = $rarity;
            return $this;
        }
    }

    /**
     * Définit la valeur marchande de l'objet
     *
     * @param int $vendor_value
     * @throws \InvalidArgumentException
     * @return Item
     */
    public function setVendorValue($vendor_value)
    {
        if (! is_numeric($vendor_value)) {
            throw new \InvalidArgumentException('La fonction attend une valeur entière. Valeur donnée : ' . var_dump($vendor_value));
        }
        $this->vendor_value = $vendor_value;
        return $this;
    }

    /**
     * Définit si et comment l'objet est lié à l'âme
     * en traduisant les termes renvoyés par l'API
     *
     * @param string $soulbind
     * @return Item
     */
    public function setSoulbind($soulbind)
    {
        if (array_key_exists($soulbind, Constants::$translation['item_flags']['soul_binding'])) {
            $this->soulbind = Constants::$translation['item_flags']['soul_binding'][$soulbind];
            return $this;
        }
    }

    /**
     * Définit si et comment l'objet est lié au compte
     * en traduisant les termes renvoyés par l'API
     *
     * @param string $accountbind
     * @return Item
     */
    public function setAccountbind($accountbind)
    {
        if (array_key_exists($accountbind, Constants::$translation['item_flags']['account_binding'])) {
            $this->accountbind = Constants::$translation['item_flags']['account_binding'][$accountbind];
            return $this;
        }
    }

    /**
     * Définit l'identifiant de l'icône de l'objet pour
     * l'API de rendu
     *
     * @param int $id
     * @throws \InvalidArgumentException
     * @return Item
     */
    public function setIconFileId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id d\'icône entier. Id donné : ' . var_dump($id));
        }
        $this->iconFileId = $id;
        return $this;
    }

    /**
     * Définit la signature de l'icône de l'objet pour
     * l'API de rendu
     *
     * @param string $signature
     * @return \SWHawkBot\Entities\Item
     */
    public function setIconFileSignature($signature)
    {
        $this->iconFileSignature = $signature;
        return $this;
    }

    /**
     * Permet d'ajouter une recette à la collection
     * de recettes permettant de produire l'objet
     *
     * @param Recipe $recipe
     * @return Item
     */
    public function addRecipe(Recipe $recipe)
    {
        $this->getRecipes()->add($recipe);
        return $this;
    }

    /**
     * Définit l'associator de l'objet
     *
     * @param ItemAssociator $associator
     * @return Item
     */
    public function setAssociator(ItemAssociator $associator)
    {
       $this->associator = $associator;
       return $this;
    }

    /**
     * Renvoie l'Id de l'objet en BDD
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Renvoie l'identifiant de l'objet auprès
     * de l'API GW2
     *
     * @return int
     */
    public function getGw2ApiId()
    {
        return $this->gw2ApiId;
    }

    /**
     * Renvoie le nom de l'objet
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Renvoie la description de l'objet
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Renvoie le type de l'objet
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Renvoie le niveau nécessaire pour
     * utiliser l'objet
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Renvoie la rareté de l'objet
     *
     * @return string
     */
    public function getRarity()
    {
        return $this->rarity;
    }

    /**
     * Renvoie la valeur marchande de l'objet
     *
     * @return int
     */
    public function getVendorValue()
    {
        return $this->vendor_value;
    }

    /**
     * Renvoie si et comment l'objet est lié à l'âme
     *
     * @return string|null
     */
    public function getSoulbind()
    {
        return $this->soulbind;
    }

    /**
     * Renvoie si et comment l'objet est lié au compte
     *
     * @return string|null
     */
    public function getAccountbind()
    {
        return $this->accountbind;
    }

    /**
     * Renvoie le tableau JSON de l'objet
     * donné par l'API GW2
     *
     * @return string
     */
    public function getItemRaw()
    {
        return $this->itemRaw;
    }

    /**
     * Renvoie l'identifiant de l'icône de l'objet
     * auprès de l'API de rendu de GW2
     *
     * @return int
     */
    public function getIconFileId()
    {
        return $this->iconFileId;
    }

    /**
     * Renvoie la signature de l'icône de l'objet
     * auprès de l'API de rendu de GW2
     *
     * @return string
     */
    public function getIconFileSignature()
    {
        return $this->iconFileSignature;
    }

    /**
     * Renvoie la collection de recettes permettant de
     * produire l'objet
     *
     * @return ArrayCollection(Recipe)
     */
    public function getRecipes()
    {
        if ($this->recipes->isEmpty())
        {
            $this->initRecipes();
        }
        return $this->recipes;
    }

    /**
     * Initialise la collection de recettes
     * permettant de produire l'objet
     */
    private function initRecipes()
    {
        foreach($this->getAssociator()->getRecipes() as $recipe)
        {
            $this->addRecipe($recipe);
        }
    }

    /**
     * Renvoie l'associator de l'objet
     *
     * @return ItemAssociator
     */
    public function getAssociator()
    {
        return $this->associator;
    }

    /**
     * Renvoie la collection de recettes pour lesquelles
     * l'objet est un ingrédient
     *
     * @return ArrayCollection(Recipe)
     */
    public function getRecipesUsedIn()
    {
        if ($this->recipesUsedIn->isEmpty())
        {
            $this->initUsedInRecipes();
        }
        return $this->recipesUsedIn;
    }

    /**
     * Initialise la collection des recettes pour
     * lesquelles l'objet est un ingrédient
     */
    private function initUsedInRecipes()
    {
        $associator = $this->getAssociator();
        for ( $i = 1 ; $i <= 4 ; $i++) {
            $recipeGetter = "getMat".$i."Recipes";
            if (!$associator->$recipeGetter()->isEmpty()) {
                foreach($associator->$recipeGetter() as $recipe)
                {
                    $this->addRecipeUsedIn($recipe);
                }
            }
        }

    }

    /**
     * Ajoute une recette à la collection des recettes
     * pour lesquelle l'objet est un ingrédient
     *
     * @param Recipe $recipe
     * @return \SWHawkBot\Entities\Item
     */
    public function addRecipeUsedIn(Recipe $recipe)
    {
        $this->recipesUsedIn->add($recipe);
        return $this;
    }
}

?>
