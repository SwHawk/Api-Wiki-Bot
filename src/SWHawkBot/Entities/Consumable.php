<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;

/**
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
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $duration;

    /**
     * Description de l'effet du consommable
     *
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $effect;

    /**
     * Type de déblocage effectué par le consommable
     *
     * @ORM\Column(type="string")
     *
     * @var unknown
     */
    protected $unlockType;

    public function __construct($consumable)
    {
        parent::_construct($consumable);
        $consumable_specific = $consumable['consumable'];

        if (isset($consumable_specific['duration_ms']))
        {
            $this->setDuration($consumable_specific['duration_ms']);
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

    public function setDuration($duration)
    {
        if (!is_int($duration))
        {
            throw new \InvalidArgumentException('La fonction attend une durée entière. Durée donnée : '.var_dump($duration));
        }
        $this->duration = $duration;
        return $this;
    }

    public function setEffect($effect)
    {
        $this->effect = $effect;
        return $this;
    }

    public function setUnlockType($type)
    {
        $this->unlockType = $type;
        return $this;
    }

    public function setType($type)
    {
        if (array_key_exists($type, Constants::$translation['item_types']['Consumable']))
        {
            $this->type = Constants::$translation['item_types']['Consumable'][$type];
        }
        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getEffect()
    {
        return $this->effect;
    }

    public function getUnlockType()
    {
        return $this->unlockType;
    }
}

?>