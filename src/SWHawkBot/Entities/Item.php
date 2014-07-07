<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

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
     * Sérialisation du tableau JSON de l'objet retourné par l'API
     *
     * @ORM\Column(type="object")
     *
     * @var string
     *
     */
    protected $raw;

    protected static $_api_rarity_array;

    protected static $_rarity_array;

    protected static $_tr_rarity_array;

    protected static $_api_soulbind_array;

    protected static $_soulbind_array;

    protected static $_tr_soulbind_array;

    /**
     * Correspondances entre les raretés renvoyées par l'API
     * et leur équivalent sur le wiki français
     */
    const API_RARITY_JUNK = "Junk";

    const RARITY_JUNK = "Déchet";

    const API_RARITY_BASIC = "Basic";

    const RARITY_BASIC = "Simple";

    const API_RARITY_FINE = "Fine";

    const RARITY_FINE = "Raffiné";

    const API_RARITY_MASTER = "Masterwork";

    const RARITY_MASTER = "Chef-d'œuvre";

    const API_RARITY_RARE = "Rare";

    const RARITY_RARE = "Rare";

    const API_RARITY_EXOTIC = "Exotic";

    const RARITY_EXOTIC = "Exotique";

    const API_RARITY_ASCENDED = "Ascended";

    const RARITY_ASCENDED = "Elevé";

    const API_RARITY_LEGENDARY = "Legendary";

    const RARITY_LEGENDARY = "Légendaire";

    const API_RARITY_ARRAY = 'a:8:{i:0;s:4:"Junk";i:1;s:5:"Basic";i:2;s:4:"Fine";i:3;s:10:"Masterwork";i:4;s:4:"Rare";i:5;s:6:"Exotic";i:6;s:8:"Ascended";i:7;s:9:"Legendary";}';

    const RARITY_ARRAY = 'a:8:{i:0;s:7:"Déchet";i:1;s:6:"Simple";i:2;s:8:"Raffiné";i:3;s:13:"Chef-d\'œuvre";i:4;s:4:"Rare";i:5;s:8:"Exotique";i:6;s:6:"Elevé";i:7;s:11:"Légendaire";}';

    const TR_RARITY_ARRAY = 'a:8:{s:4:"Junk";s:7:"Déchet";s:5:"Basic";s:6:"Simple";s:4:"Fine";s:8:"Raffiné";s:10:"Masterwork";s:13:"Chef-d\'œuvre";s:4:"Rare";s:4:"Rare";s:6:"Exotic";s:8:"Exotique";s:8:"Ascended";s:6:"Elevé";s:9:"Legendary";s:11:"Légendaire";}';

    /**
     * Correspondance entre les liaisons (à l'âme, au compte) renvoyée par l'API
     * et leur équivalent sur le wiki français
     */
    const API_SOULBIND_ON_USE = "SoulBindOnUse";

    const SOULBIND_ON_USE = "Utilisation";

    const API_SOULBIND_ON_ACQUIRE = "SoulBindOnAcquire";

    const SOULBIND_ON_ACQUIRE = "Acquisition";

    const API_SOULBIND = "SoulBind";

    const SOULBIND = "Ame";

    const API_SOULBIND_ARRAY = 'a:3:{i:0;s:13:"SoulBindOnUse";i:1;s:17:"SoulBindOnAcquire";i:2;s:8:"SoulBind";}';

    const SOULBIND_ARRAY = 'a:3:{i:0;s:11:"Utilisation";i:1;s:11:"Acquisition";i:2;s:3:"Ame";}';

    const TR_SOULBIND_ARRAY = 'a:3:{s:13:"SoulBindOnUse";s:11:"Utilisation";s:17:"SoulBindOnAcquire";s:11:"Acquisition";s:8:"SoulBind";s:3:"Ame";}';

    const API_ACCOUNT_BIND = "AccountBound";

    const API_ACCOUNT_BIND_ON_USE = "AccountBindOnUse";

    const ACCOUNT_BIND = "Oui";

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
        
        if (! is_array(self::$_api_rarity_array)) {
            self::initPrivateArrays();
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
                if (strpos($flag, "Soul") == 0) {
                    $this->setSoulbind($flag);
                } elseif (strpos(flag, "Account") == 0) {
                    $this->setAccountbind($flag);
                }
            }
        }
        
        if (isset($item['icon_file_id'])) {
            $this->setIconFileId($item['icon_file_id']);
            $this->setIconFileSignature($item['icon_file_signature']);
        }
        
        $this->raw = $item;
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
        if (in_array($rarity, $this->getRarityArray())) {
            $this->rarity = $rarity;
            return $this;
        }
        if (in_array($rarity, $this->getApiRarityArray())) {
            $this->rarity = $this->getTrRarityArray()[$rarity];
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
        if (in_array($soulbind, $this->getSoulbindArray())) {
            $this->soulbind = $soulbind;
            return $this;
        }
        if (in_array($soulbind, $this->getApiSoulbindArray())) {
            $this->soulbind = $this->getTrSoulbindArray()[$soulbind];
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
        if ($accountbind == self::API_ACCOUNT_BIND || $accountbind == self::ACCOUNT_BIND) {
            $this->accountbind = self::ACCOUNT_BIND;
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

    /**
     * Cette fonction initialise les array statiques permettant la correspondance
     * entre les valeurs renvoyées par l'API et les valeurs pour le wiki
     *
     * @return void
     */
    protected static function initPrivateArrays()
    {
        self::$_api_rarity_array = unserialize(self::API_RARITY_ARRAY);
        self::$_rarity_array = unserialize(self::RARITY_ARRAY);
        self::$_tr_rarity_array = unserialize(self::TR_RARITY_ARRAY);
        self::$_api_soulbind_array = unserialize(self::API_SOULBIND_ARRAY);
        self::$_soulbind_array = unserialize(self::SOULBIND_ARRAY);
        self::$_tr_soulbind_array = unserialize(self::TR_SOULBIND_ARRAY);
    }

    /**
     *
     * @return array
     */
    protected function getApiRarityArray()
    {
        if (! is_array(self::$_api_rarity_array)) {
            self::initPrivateArrays();
        }
        return self::$_api_rarity_array;
    }

    /**
     *
     * @return array
     */
    protected function getRarityArray()
    {
        if (! is_array(self::$_rarity_array)) {
            self::initPrivateArrays();
        }
        return self::$_rarity_array;
    }

    /**
     *
     * @return array
     */
    protected function getTrRarityArray()
    {
        if (! is_array(self::$_tr_rarity_array)) {
            self::initPrivateArrays();
        }
        return self::$_tr_rarity_array;
    }

    /**
     *
     * @return array
     */
    protected function getApiSoulbindArray()
    {
        if (! is_array(self::$_api_soulbind_array)) {
            self::initPrivateArrays();
        }
        return self::$_api_soulbind_array;
    }

    /**
     *
     * @return array
     */
    protected function getSoulbindArray()
    {
        if (! is_array(self::$_soulbind_array)) {
            self::initPrivateArrays();
        }
        return self::$_soulbind_array;
    }

    /**
     *
     * @return array
     */
    protected function getTrSoulbindArray()
    {
        if (! is_array(self::$_tr_soulbind_array)) {
            self::initPrivateArrays();
        }
        return self::$_tr_soulbind_array;
    }
}

?>
