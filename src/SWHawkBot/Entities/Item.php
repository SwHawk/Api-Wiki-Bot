<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;

/**
 * Cette classe *abstraite* représente un objet quelconque du jeu.
 * Elle n'est pas censée être utilisée car tout objet de la classe **Item**
 * ne sera pas persisté en base de donnée
 *
 * @author SwHawk
 *
 *         @ORM\MappedSuperClass
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
    protected $gw2apiId;

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
     * @ORM\Column(type="string")
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
     * Correspondance entre les liaisons (à l'âme, au compte) renvoyée par l'API
     * et leur équivalent sur le wiki français
     */


    /**
     * Constructeur de l'objet, possiblement à partir d'un array
     * provenant de l'API GuildWars2
     *
     * @param array $item|null
     * @return Item
     */
    public function __construct($item = null)
    {
        if (is_null($item)) {
            return $this;
        }

        if (isset($item['item_id'])) {
            $this->setGw2apiId($item['item_id']);
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
                if (array_key_exists($flag, Constants::$translation['item_flags']['soul_binding']))
                {
                    $this->setSoulbind($flag);
                } elseif (array_key_exists($flag, Constants::$translation['item_flags']['account_binding']))
                {
                    $this->setAccountbind($flag);
                }
            }
        }

        if (isset($item['icon_file_id'])) {
            $this->setIconFileId($item['icon_file_id']);
            $this->setIconFileSignature($item['icon_file_signature']);
        }

        $this->raw = $item;
        return $this;
    }

    /**
     *
     * @param int $id
     * @throws \InvalidArgumentException
     * @return Item
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
     * @param string $name
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
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
     *
     * @param string $rarity
     * @return Item
     */
    public function setRarity($rarity)
    {
        if (array_key_exists($rarity, Constants::$translation['rarity']))
        {
            $this->rarity = Constants::$translation['rarity'][$rarity];
            return $this;
        }
    }

    /**
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
     *
     * @param string $soulbind
     * @return Item
     */
    public function setSoulbind($soulbind)
    {
        if (array_key_exists($soulbind, Constants::$translation['item_flags']['soul_bind']))
        {
            $this->soulbind = Constants::$translation['item_flags']['soul_bind'][$soulbind];
            return $this;
        }
    }

    /**
     *
     * @param string $accountbind
     * @return Item
     */
    public function setAccountbind($accountbind)
    {
    if (array_key_exists($soulbind, Constants::$translation['item_flags']['account_bind']))
        {
            $this->accountbind = Constants::$translation['item_flags']['account_bind'][$accountbind];
            return $this;
        }
    }

    /**
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
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return int
     */
    public function getGw2apiId()
    {
        return $this->gw2apiId;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     *
     * @return string
     */
    public function getRarity()
    {
        return $this->rarity;
    }

    /**
     *
     * @return int
     */
    public function getVendorValue()
    {
        return $this->vendor_value;
    }

    /**
     *
     * @return string
     */
    public function getSoulbind()
    {
        return $this->soulbind;
    }

    /**
     *
     * @return string
     */
    public function getAccountbind()
    {
        return $this->accountbind;
    }

    /**
     *
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     *
     * @return int
     */
    public function getIconFileId()
    {
        return $this->iconFileId;
    }

    /**
     *
     * @return string
     */
    public function getIconFileSignature()
    {
        return $this->iconFileSignature;
    }

}

?>
