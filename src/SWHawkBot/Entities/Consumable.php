<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;

/**
 * Modèle de donnée des consommables
 *
 * @author swhawk
 *
 * @ORM\Entity
 * @ORM\Table(name="Consumables")
 */
class Consumable extends Item
{

    /**
     * Durée de l'effet du consommable en ms
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     */
    protected $duration;

    /**
     * Description de l'effet du consommable
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $effect;

    /**
     * Type de déblocage effectué par le consommable
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var unknown
     */
    protected $unlockType;

    /**
     * Constructeur faisant appel au constructeur
     * de la classe parente
     *
     * @param arrray $consumable
     * @return Consumable
     */
    public function __construct($consumable)
    {
        parent::__construct($consumable);
        $consumable_specific = $consumable['consumable'];

        if (isset($consumable_specific['type']))
        {
            $this->setType($consumable_specific['type']);
        }

        if (isset($consumable_specific['duration_ms']))
        {
            $this->setDuration((int) $consumable_specific['duration_ms']);
        }

        if (isset($consumable_specific['description']))
        {
            $this->setEffect($consumable_specific['description']);
        }

        if (isset($consumable_specific['unlock_type']))
        {
            $this->setUnlockType($consumable_specific['unlock_type']);
        }

        return $this;
    }

    /**
     * Définit la durée de l'effet du consommable
     * en ms
     *
     * @param integer $duration
     * @throws \InvalidArgumentException
     * @return \SWHawkBot\Entities\Consumable
     */
    public function setDuration($duration)
    {
        if (!is_int($duration))
        {
            throw new \InvalidArgumentException('La fonction attend une durée entière. Durée donnée : '.var_dump($duration));
        }
        $this->duration = $duration;
        return $this;
    }

    /**
     * Définit l'effet du consommable
     *
     * @param string $effect
     * @return \SWHawkBot\Entities\Consumable
     */
    public function setEffect($effect)
    {
        $this->effect = $effect;
        return $this;
    }

    /**
     * Définit le type de déblocage fourni
     * par le consommable
     *
     * @param string $type
     * @return \SWHawkBot\Entities\Consumable
     */
    public function setUnlockType($type)
    {
        $this->unlockType = $type;
        return $this;
    }

    /**
     * Surcharge de la classe parente
     *
     * @see \SWHawkBot\Entities\Item::setType()
     */
    public function setType($type)
    {
        if (array_key_exists($type, Constants::$translation['item_types']['Consumable']))
        {
            $this->type = Constants::$translation['item_types']['Consumable'][$type];
        }
        return $this;
    }

    /**
     * Renvoie la durée de l'effet du consommable
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Renvoie la description de l'effet du consommable
     *
     * @return string
     */
    public function getEffect()
    {
        return $this->effect;
    }

    /**
     * Renvoie le type de déblocage fourni par le
     * consommable
     *
     * @return \SWHawkBot\Entities\unknown
     */
    public function getUnlockType()
    {
        return $this->unlockType;
    }
}

?>