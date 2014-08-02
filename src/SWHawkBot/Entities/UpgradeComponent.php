<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;

/**
 *
 * @author swhawk
 *
 * @ORM\Entity
 * @ORM\Table(name="UpgradeComponents")
 */
class UpgradeComponent extends BonusItem
{
    /**
     * Types d'objets sur lesquels le composant
     * peut-être appliqué
     *
     * @ORM\Column(type="array")
     *
     * @var string[]
     */
    protected $flags;

    /**
     * Type de slots d'infusion sur lesquels le composant
     * peut être appliqué
     *
     * @ORM\Column(type="array")
     *
     * @var string[]
     */
    protected $infusionUpgradeFlags;

    /**
     * Description des bonus conférés par la rune
     *
     * @ORM\Column(type="array")
     *
     * @var string[]
     */
    protected $bonuses;

    /**
     * Suffixe donné par le composant
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $suffix;

    public function __construct($component)
    {
        parent::__construct($component);

        $component_specific = $component['upgrade_component'];

        if (isset($component_specific['type']))
        {
            $this->setType($component_specific['type']);
        }

        if (isset($component_specific['flags']))
        {
            $this->setFlags($component_specific['flags']);
        }

        if (isset($component_specific['infusion_upgrade_flags']))
        {
            $this->setInfusionUpgradeFlags($component_specific['infusion_upgrade_flags']);
        }

        if (isset($component_specific['bonuses']))
        {
            $this->setBonuses($component_specific['bonuses']);
        }

        if (isset($component_specific['suffix']))
        {
            $this->setSuffix($component_specific['suffix']);
        }

        return $this;
    }

    public function setType($type)
    {
        if (array_key_exists($type, Constants::$translation['item_types']['UpgradeComponent']))
        {
            $this->type = Constants::$translation['item_types']['UpgradeComponent'][$type];
        }
        return $this;
    }

    public function setFlags(array $flags)
    {
        $this->flags = $flags;
        return $this;
    }

    public function setInfusionUpgradeFlags(array $flags)
    {
        $this->infusionUpgradeFlags = $flags;
        return $this;
    }

    public function setBonuses(array $bonuses)
    {
        $this->bonuses = $bonuses;
        return $this;
    }

    public function setSuffix($suffix)
    {
        if (!is_string($suffix))
        {
            throw new \InvalidArgumentException('La fonction attend un suffix de type chaîne de caractères. Suffixe donné : '.var_dump($suffix));
        }
        $this->suffix = $suffix;
        return $this;
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function getInfusionUpgradeFlags()
    {
        return $this->infusionUpgradeFlags;
    }

    public function getBonuses()
    {
        return $this->bonuses;
    }

    public function getSuffix()
    {
        return $this->suffix;
    }
}

?>