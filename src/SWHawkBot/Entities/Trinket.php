<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author swhawk
 *
 * @ORM\Entity
 * @ORM\Table(name="Trinkets")
 */
class Trinket extends BonusItem
{

    const API_TYPE_RING = "Ring";

    const TYPE_RING = "Anneau";

    const API_TYPE_AMULET = "Amulet";

    const TYPE_AMULET = "Amulette";

    const API_TYPE_EARRING = "Earring";

    const TYPE_EARRING = "Accessoire";

    const API_TYPE_TRINKET = "Trinket";

    public function __construct($trinket = null)
    {
        parent::__construct($trinket);

        $trinket_specific = $trinket['trinket'];

        $this->setType($trinket_specific['type']);
        if (is_null($this->getType()))
        {
            throw new \InvalidArgumentException("Pas de type pour l'accessoire : ".print_r($trinket)."\n");
        }

        return $this;
    }

    public function setType($type)
    {
        if ($type == self::API_TYPE_AMULET || $type == self::TYPE_AMULET) {
            $this->type = self::TYPE_AMULET;
            return $this;
        }

        if ($type == self::API_TYPE_EARRING || $type == self::TYPE_EARRING || $type = self::API_TYPE_TRINKET) {
            $this->type = self::TYPE_EARRING;
            return $this;
        }

        if ($type == self::API_TYPE_RING || $type == self::TYPE_RING) {
            $this->type = self::TYPE_RING;
            return $this;
        }
    }
}
?>