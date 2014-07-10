<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;

/**
 * Modèle de données des armes de GuildWars2
 *
 * @author SwHawk
 *
 *         @ORM\Entity @ORM\Table(name="Weapons", indexes={@ORM\Index(name="gw2apiid_idx",columns={"gw2apiId"})})
 */
class Weapon extends BonusItem
{

    /**
     * Type des dégâts infligés par l'arme
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $damageType;

    /**
     * Puissance minimale de l'arme
     *
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $minPower;

    /**
     * Puissance maximale de l'arme
     *
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $maxPower;

    /**
     * Défense octroyée par l'arme (bouclier uniquement)
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $defense;

    /**
     * Constructeur de la classe, faisant appel aux
     * constructeurs des classes parentes
     *
     * @see \SWHawkBot\Entities\BonusItem::__construct()
     * @see \SWHawkBot\Entities\Item::__construct()
     * @param array|null $weapon
     * @throws \InvalidArgumentException
     * @return Weapon
     */
    public function __construct($weapon = null)
    {
        parent::__construct($weapon);

        $weapon_specific = $weapon['weapon'];

        $this->setType($weapon_specific['type']);
        if (is_null($this->getType())) {
            throw new \InvalidArgumentException('Le type est null pour l\'item : ' . print_r($weapon));
        }

        $this->setDamageType($weapon_specific['damage_type']);

        $this->setMinPower($weapon_specific['min_power']);

        $this->setMaxPower($weapon_specific['max_power']);

        if ($weapon_specific['defense'] > 0) {
            $this->setDefense($weapon_specific['defense']);
        }

        return $this;
    }

    /**
     *
     * @param string $type
     * @return Weapon
     */
    public function setDamageType($type)
    {
        if (array_key_exists($type, Constants::$translation['damage_types']))
        {
            $this->damageType = Constants::$translation['damage_types'][$type];
            return $this;
        }
        $this->damageType = type;
        return $this;
    }

    /**
     *
     * @see \SWHawkBot\Entities\Item::setType()
     * @return Weapon
     */
    public function setType($type)
    {
        if (array_key_exists($type, Constants::$translation['item_types']['Weapon']))
        {
            $this->type = Constants::$translation['item_types']['Weapon'][$type];
            return $this;
        }
        $this->type = $type;
        return $this;
    }

    /**
     *
     * @param integer $power
     * @throws \InvalidArgumentException
     * @return Weapon
     */
    public function setMinPower($power)
    {
        if (! is_numeric($power)) {
            throw new \InvalidArgumentException('La fonction attend une puissance entière. Puissance donnée : ' . var_dump($power));
        }
        $this->minPower = $power;
        return $this;
    }

    /**
     *
     * @param integer $power
     * @throws \InvalidArgumentException
     * @return Weapon
     */
    public function setMaxPower($power)
    {
        if (! is_numeric($power)) {
            throw new \InvalidArgumentException('La fonction attend une puissance entière. Puissance donnée : ' . var_dump($power));
        }
        $this->maxPower = $power;
        return $this;
    }

    /**
     *
     * @param integer $defense
     * @throws \InvalidArgumentException
     * @return Weapon
     */
    public function setDefense($defense)
    {
        if (! is_numeric($defense)) {
            throw new \InvalidArgumentException('La fonction attend une puissance entière. Puissance donnée : ' . var_dump($defense));
        }
        $this->defense = $defense;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDamageType()
    {
        return $this->damageType;
    }

    /**
     *
     * @return number
     */
    public function getMinPower()
    {
        return $this->minPower;
    }

    /**
     *
     * @return number
     */
    public function getMaxPower()
    {
        return $this->maxPower;
    }

    /**
     *
     * @return integer|null
     */
    public function getDefense()
    {
        return $this->defense;
    }
}
?>
