<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe *abstraite* pour les objets donnant
 * un skill de buff passif (composants d'amélioration...)
 *
 * @author swhawk
 *
 * @ORM\MappedSuperClass
 */
class BuffItem extends Item
{
    /**
     * Identifiant du skill de buff de l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|nullc
     */
    protected $buffSkillId = null;

    /**
     * Description du skill de buff de l'objet
     *
     * @ORM\column(type="text", nullable=true)
     *
     * @var string|null
     */
    protected $buffSkillDescription = null;

    /**
     * Définit l'identifiant du skill de buff
     *
     * @param integer $modifier
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setBuffSkillId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->buffSkillId = $id;
        return $this;
    }

    /**
     * Définit la description du skill de buff
     *
     * @param integer $modifier
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setBuffSkillDescription($description)
    {
        $this->buffSkillDescription = $description;
        return $this;
    }

    /**
     * Renvoie l'identifiant du skill de buff
     *
     * @return integer|null
     */
    public function getBuffSkillId()
    {
        return $this->buffSkillId;
    }

    /**
     * Renvoie la description du skill de buff
     *
     * @return string|null
     */
    public function getBuffSkillDescription()
    {
        return $this->buffSkillDescription;
    }
}

?>