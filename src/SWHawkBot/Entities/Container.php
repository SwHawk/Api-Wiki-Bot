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
     *
     * @ORM\Column(type="string")
     * @var string
     */
    protected $type = "Conteneur";

    /**
     *
     * @param string $container
     * @return Container
     */
    public function __construct($container = null)
    {
        parent::__construct($container);

        $this->setType();
        return $this;
    }

    /**
     *
     * @see \SWHawkBot\Entities\Item::setType()
     * @return Container
     */
    public function setType()
    {
        $this->type = "Conteneur";
        return $this;
    }
}
?>