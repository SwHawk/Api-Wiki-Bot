<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle de données des conteneurs, objets type sacoche d'armure
 *
 * @author swhawk
 *
 *         @ORM\Entity
 *         @ORM\Table(name="Containers")
 */
class Container extends Item
{

    /**
     * Constructeur faisant appel au constructeur parent
     *
     * @param string $container
     * @return Container
     */
    public function __construct($container = null)
    {
        parent::__construct($container);

        $this->setType(null);

        return $this;
    }

    /**
     * Surcharge de la méthode parente
     *
     * @see \SWHawkBot\Entities\Item::setType()
     * @return Container
     */
    public function setType($type)
    {
        $this->type = "Conteneur";

        return $this;
    }
}
?>