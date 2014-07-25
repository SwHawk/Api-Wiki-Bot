<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;

/**
 * Modèle de données des Gizmo (certains
 * toniques)
 *
 * @author swhawk
 *
 * @ORM\Entity
 * @ORM\Table(name="Gizmos")
 */
class Gizmo extends Item
{
    /**
     * Constructeur faisant appel au
     * constructeur de la classe parentes
     *
     * @param string $gizmo
     * @return Gizmo
     */
    public function __construct($gizmo = null)
    {
        parent::__construct($gizmo);

        $this->setType($gizmo['gizmo']['type']);

        return $this;
    }

    /**
     * Surcharge de la méthode parente
     *
     * @see \SWHawkBot\Entities\Item::setType()
     */
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