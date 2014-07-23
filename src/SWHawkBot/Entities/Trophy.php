<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author swhawk
 *
 * @ORM\Entity
 * @ORM\Table(name="Trophies")
 */
class Trophy extends Item
{
    public function setType($type)
    {
        $this->type = "Trophée";
        return $this;
    }
}

?>