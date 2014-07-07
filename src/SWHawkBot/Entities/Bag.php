<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle de données des sacs
 *
 * @author SwHawk
 *        
 *         @ORM\Entity @ORM\Table(name="Bags")
 */
class Bag extends Item
{

    /**
     * Taille du sac
     *
     * @ORM\Column(type="smallint")
     * 
     * @var integer
     */
    protected $size;

    /**
     * Possibilité de compacter ou de vendre les objets
     * dans le sac auprès d'un vendeur
     *
     * @ORM\Column(type="boolean")
     * 
     * @var boolean
     */
    protected $noSellOrSort;

    public function __construct($bag = null)
    {
        parent::__construct($bag);
        
        $bag_specific = $bag['bag'];
        
        if (isset($bag_specific['size'])) {
            $this->setSize($bag_specific['size']);
        }
        
        if (isset($bag_specific['no_sell_or_sort'])) {
            $this->setNoSellOrSort($bag_specific['no_sell_or_sort']);
        }
        
        return $this;
    }

    /**
     *
     * @param integer $size            
     * @throws \InvalidArgumentException
     * @return \SWHawkBot\Entities\Bag
     */
    public function setSize($size)
    {
        if (! is_numeric($size)) {
            throw new \InvalidArgumentException('La fonction attend une taille entière. Taille donnée : ' . var_dump($size));
        }
        $this->size = $size;
        return $this;
    }

    /**
     *
     * @param integer $noSellOrSort            
     * @throws \InvalidArgumentException
     * @return \SWHawkBot\Entities\Bag
     */
    public function setNoSellOrSort($noSellOrSort)
    {
        if (! is_numeric($noSellOrSort)) {
            throw new \InvalidArgumentException('La fonction attend un booleen ou un nombre. Argument donné : ' . var_dump($noSellOrSort));
        }
        $this->noSellOrSort = (bool) $noSellOrSort;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     *
     * @return boolean
     */
    public function getNoSellOrSort()
    {
        return $this->noSellOrSort;
    }
}
?>
