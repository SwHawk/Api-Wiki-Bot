<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author swhawk
 *
 * @ORM\Entity
 * @ORM\Table(name="CraftingMaterials")
 */
class CraftingMaterial extends Item
{
    /**
     * Pré-requis pour ce matériau d'artisanat
     *
     * @ORM\Column(type="array")
     *
     * @var array
     */
    protected $prerequisites;

    public function setPrerequisites(array $prerequisites)
    {
        $this->prerequisites = $prerequisites;
    }

    public function getPrerequisites()
    {
        return $this->prerequisites;
    }
}