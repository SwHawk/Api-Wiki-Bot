<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle de données des sacs à dos
 *
 * @author swhawk
 *
 * @ORM\Entity
 * @ORM\Table(name="Backs")
 */
class Back extends BonusItem
{
    /**
     * Constructeur de la classe, faisant
     * appel aux contructeurs des classes parentes
     *
     * @param unknown $back
     * @return \SWHawkBot\Entities\Back
     */
    public function __construct($back)
    {
        parent::__construct($back);

        $this->setType(null);

        return $this;
    }

    /**
     * Définit le type de l'objet à Sac à dos
     *
     * @see \SWHawkBot\Entities\Item::setType()
     */
    public function setType($type)
    {
        $this->type = "Sac à dos";
        return $this;
    }
}

?>