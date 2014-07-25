<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle de données des matériaux d'artisanat
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

    /**
     * Constructeur appelant le constructeur de la
     * classe parente
     *
     * @param array $material
     * @return CraftingMaterial
     */
    public function __construc($material)
    {
        parent::__construct($material);

        $this->setType(null);

        return $this;
    }

    /**
     * Définit les pré-requis pour le matériau
     * d'artisanat
     *
     * @param array $prerequisites
     * @return CraftingMaterial
     */
    public function setPrerequisites(array $prerequisites)
    {
        $this->prerequisites = $prerequisites;
        return $this;
    }

    /**
     * Retourne les pré-requis pour le matériau
     * d'artisanat
     *
     * @return array
     */
    public function getPrerequisites()
    {
        return $this->prerequisites;
    }

    /**
     * Surcharge de la méthode parente
     *
     * @see \SWHawkBot\Entities\Item::setType()
     */
    public function setType($type)
    {
        $this->type = "Matériau d'artisanat";
    }
}