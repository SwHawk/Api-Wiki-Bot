<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;

/**
 *
 * @author swhawk
 *
 * @ORM\Entity
 * @ORM\Table(name="Gizmos")
 */
class Gizmo extends Item
{
    public function __construct($gizmo = null)
    {
        parent::__construct($gizmo);

        $this->setType($gizmo['gizmo']['type']);

        return $this;
    }

    public function setType($type)
    {
        if (array_key_exists($type, Constants::$translation['item_types']['Gizmo']))
        {
            $this->type = Constants::$translation['item_types']['Gizmo'][$type];
        } else {
            $this->type;
        }
        return $this;
    }
}