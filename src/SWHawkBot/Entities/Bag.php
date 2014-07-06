<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name="Bags")
 */
class Bag extends Item {
	
	/**
	 * @ORM\Column(type="smallint")
	 */
	protected $size;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $noSellOrSort;
		
	public function __construct($weapon = null) {
		parent::__construct($weapon);
			
		return $this;
	}

}
?>
