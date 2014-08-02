<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;

/**
 *
 * @author swhawk
 *
 *         @ORM\Entity
 *         @ORM\Table(name="Trinkets")
 */
class Trinket extends BonusItem
{

    public function __construct($trinket = null)
    {
        parent::__construct($trinket);

        $trinket_specific = $trinket['trinket'];

        $this->setType($trinket_specific['type']);
        if (is_null($this->getType()))
        {
            throw new \InvalidArgumentException("Pas de type pour l'accessoire : " . print_r($trinket) . "\n");
        }

        return $this;
    }

    public function setType($type)
    {
        if (array_key_exists($type, Constants::$translation['item_types']['Trinket']))
        {
            $this->type = Constants::$translation['item_types']['Trinket'][$type];
            return $this;
        }
    }

    public function createWikiText()
    {
        $wikitext =
        "<nowiki>\n{{Infobox d'accessoire\n".
        "| nom = ".$this->getName().
        "| description =".
        "| niveau = ".$this->getLevel().
        "| rareté = ".$this->getRarity().
        "| lié = ".$this->getSoulbind()." ".$this->getAccountbind();
    }
}
?>