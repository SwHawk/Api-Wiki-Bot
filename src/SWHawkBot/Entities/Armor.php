<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;

/**
 * Modèle de données des pièces d'armures de GuildWars 2
 *
 * @author SwHawk
 *
 *         @ORM\Entity @ORM\Table(name="Armorpieces")
 */
class Armor extends BonusItem
{

    /**
     * Classe d'armure de la pièce
     *
     * Valeur possibles : Intermédiaire, Léger, Lourd
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $weightClass;

    /**
     * Défense octroyée par la pièce d'armure
     *
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $defense;

    /**
     * Constructeur de la classe, faisant appel aux
     * constructeurs des classes parentes
     *
     * @param array|null $armor
     * @return Armor
     */
    public function __construct($armor = null)
    {
        parent::__construct($armor);
        $armor_specific = $armor['armor'];

        $this->setType($armor_specific['type']);

        $this->setWeightClass($armor_specific['weight_class']);

        $this->setDefense($armor_specific['defense']);

        return $this;
    }

    /**
     *
     * @param string $class
     * @return Armor
     */
    public function setWeightClass($class)
    {
        if (array_key_exists($class, Constants::$translation['armor_weight']))
        {
            $this->weightClass = Constants::$translation['armor_weight'][$class];
            return $this;
        }
        $this->weightClass = $class;
        return $this;
    }

    /**
     *
     * @see \SWHawkBot\Entities\Item::setType()
     */
    public function setType($type)
    {
        if (array_key_exists($type, Constants::$translation['item_types']['Armor'])) {
            $this->type = Constants::$translation['item_types']['Armor'][$type];
            return $this;
        }
        $this->type = $type;
        return $this;
    }

    /**
     *
     * @param integer $defense
     * @throws \InvalidArgumentException
     * @return Armor
     */
    public function setDefense($defense)
    {
        if (! is_numeric($defense)) {
            throw new \InvalidArgumentException('La fonction attend une défense entière. Défense donnée : ' . var_dump($defense));
        }
        $this->defense = $defense;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     *
     * @return string
     */
    public function getWeightClass()
    {
        return $this->weightClass;
    }
}

?>
