<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author swhawk
 *
 * @ORM\Entity
 * @ORM\Table(name="Backs")
 */
class Back extends BonusItem
{
    public function setType($type)
    {
        $this->type = "Sac à dos";
        return $this;
    }
}

?>