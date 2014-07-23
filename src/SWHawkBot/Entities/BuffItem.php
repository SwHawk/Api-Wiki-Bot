<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
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
     *
     * @return integer|null
     */
    public function getBuffSkillId()
    {
        return $this->buffSkillId;
    }

    /**
     *
     * @return string|null
     */
    public function getBuffSkillDescription()
    {
        return $this->buffSkillDescription;
    }
}

?>