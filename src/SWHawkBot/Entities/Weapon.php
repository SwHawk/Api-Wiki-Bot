<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle de données des armes de GuildWars2
 * 
 * @author SwHawk
 * 
 * @ORM\Entity @ORM\Table(name="Weapons")
 */
class Weapon extends BonusItem {
	
	/**
	 * Type des dégâts infligés par l'arme
	 * 
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	protected $damageType;
	
	/**
	 * Puissance minimale de l'arme
	 * 
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	protected $minPower;
	
	/**
	 * Puissance maximale de l'arme
	 * 
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	protected $maxPower;
	
	/**
	 * Défense octroyée par l'arme (bouclier uniquement)
	 * 
	 * @ORM\Column(type="integer", nullable=true)
	 * @var integer|null
	 */
	protected $defense;
	
	/**
	 * Correspondances API/wiki-fr types de dommages
	 */
	const API_TYPE_CHOKING = "Choking";
	const TYPE_CHOKING = "Ténèbres";
	const API_TYPE_FIRE = "Fire";
	const TYPE_FIRE = "Feu";
	const API_TYPE_ICE = "Ice";
	const TYPE_ICE = "Glace";
	const API_TYPE_LIGHTNING = "Lightning";
	const TYPE_LIGHTNING = "Air";
	const API_TYPE_PHYSICAL = "Physical";
	const TYPE_PHYSICAL = "Physique";

	
	/**
	 * Constructeur de la classe, faisant appel aux
	 * constructeurs des classes parentes
	 * 
	 * @see \SWHawkBot\Entities\BonusItem::__construct()
	 * @see \SWHawkBot\Entities\Item::__construct()
	 * @param array|null $weapon
	 * @throws \InvalidArgumentException
	 * @return Weapon
	 */
	public function __construct($weapon = null) {
		parent::__construct($weapon);
		
		$weapon_specific = $weapon['weapon'];
		
		$this->setType($weapon_specific['type']);
		if (is_null($this->getType())) {
			throw new \InvalidArgumentException('Le type est null pour l\'item : '.print_r($weapon));
		}
		
		$this->setDamageType($weapon_specific['damage_type']);
		
		$this->setMinPower($weapon_specific['min_power']);
		
		$this->setMaxPower($weapon_specific['max_power']);
		
		if ($weapon_specific['defense'] > 0) {
			$this->setDefense($weapon_specific['defense']);
		}
		
		return $this;
	}

	/**
	 * @param string $type
	 * @return Weapon
	 */
	public function setDamageType($type) {
		if ($type == self::API_TYPE_CHOKING || $type == self::TYPE_CHOKING) {
			$this->damageType = self::TYPE_CHOKING;
			return $this;
		}
		if ($type == self::API_TYPE_FIRE || $type == self::TYPE_FIRE) {
			$this->damageType = self::TYPE_FIRE;
			return $this;
		}
		if ($type == self::API_TYPE_ICE || $type == self::TYPE_ICE) {
			$this->damageType = self::TYPE_ICE;
			return $this;
		}
		if ($type == self::API_TYPE_LIGHTNING || $type == self::TYPE_LIGHTNING) {
			$this->damageType = self::TYPE_LIGHTNING;
			return $this;
		}
		if ($this == self::API_TYPE_PHYSICAL || $type == self::TYPE_PHYSICAL) {
			$this->damageType = self::TYPE_PHYSICAL;
			return $this;
		}
	}
	
	/**
	 * @see \SWHawkBot\Entities\Item::setType()
	 * @return Weapon
	 */
	public function setType($type) {
		if($type == self::API_TYPE_AXE || $type == self::TYPE_AXE) {
            $this->type=self::TYPE_AXE;
            return $this;
        }

		if($type == self::API_TYPE_DAGGER || $type == self::TYPE_DAGGER) {
            $this->type=self::TYPE_DAGGER;
            return $this;
        }

		if($type == self::API_TYPE_FOCUS || $type == self::TYPE_FOCUS) {
            $this->type=self::TYPE_FOCUS;
            return $this;
        }

		if($type == self::API_TYPE_GREATSWORD || $type == self::TYPE_GREATSWORD) {
            $this->type=self::TYPE_GREATSWORD;
            return $this;
        }

		if($type == self::API_TYPE_HAMMER || $type == self::TYPE_HAMMER) {
            $this->type=self::TYPE_HAMMER;
            return $this;
        }
        
        if($type == self::API_TYPE_HARPOON || $type == self::TYPE_HARPOON) {
			$this->type=self::TYPE_HARPOON;
			return $this;
		}

		if($type == self::API_TYPE_LONGBOW || $type == self::TYPE_LONGBOW) {
            $this->type=self::TYPE_LONGBOW;
            return $this;
        }

		if($type == self::API_TYPE_MACE || $type == self::TYPE_MACE) {
            $this->type=self::TYPE_MACE;
            return $this;
        }

		if($type == self::API_TYPE_PISTOL || $type == self::TYPE_PISTOL) {
            $this->type=self::TYPE_PISTOL;
            return $this;
        }

		if($type == self::API_TYPE_RIFLE || $type == self::TYPE_RIFLE) {
            $this->type=self::TYPE_RIFLE;
            return $this;
        }

		if($type == self::API_TYPE_SCEPTER  || $type == self::TYPE_SCEPTER) {
            $this->type=self::TYPE_SCEPTER;
            return $this;
        }

		if($type == self::API_TYPE_SHIELD || $type == self::TYPE_SHIELD) {
            $this->type=self::TYPE_SHIELD;
            return $this;
        }

		if($type == self::API_TYPE_SHORTBOW || $type == self::TYPE_SHORTBOW) {
            $this->type=self::TYPE_SHORTBOW;
            return $this;
        }

		if($type == self::API_TYPE_SPEARGUN || $type == self::TYPE_SPEARGUN) {
            $this->type=self::TYPE_SPEARGUN;
            return $this;
        }

		if($type == self::API_TYPE_STAFF || $type == self::TYPE_STAFF) {
            $this->type=self::TYPE_STAFF;
            return $this;
        }

		if($type == self::API_TYPE_SWORD  || $type == self::TYPE_SWORD) {
            $this->type=self::TYPE_SWORD;
            return $this;
        }

		if($type == self::API_TYPE_TORCH  || $type == self::TYPE_TORCH) {
            $this->type=self::TYPE_TORCH;
            return $this;
        }

		if($type == self::API_TYPE_TRIDENT  || $type == self::TYPE_TRIDENT) {
            $this->type=self::TYPE_TRIDENT;
            return $this;
        }
		if($type == self::API_TYPE_WARHORN  || $type == self::TYPE_WARHORN) {
            $this->type=self::TYPE_WARHORN;
            return $this;
        }
	}
    
	/**
	 * @param integer $power
	 * @throws \InvalidArgumentException
	 * @return Weapon
	 */
    public function setMinPower($power) {
		if (!is_numeric($power)) {
			throw new \InvalidArgumentException('La fonction attend une puissance entière. Puissance donnée : '.var_dump($power));
		}
		$this->minPower = $power;
		return $this;
	}
	
	/**
	 * @param integer $power
	 * @throws \InvalidArgumentException
	 * @return Weapon
	 */
	public function setMaxPower($power) {
		if (!is_numeric($power)) {
			throw new \InvalidArgumentException('La fonction attend une puissance entière. Puissance donnée : '.var_dump($power));
		}
		$this->maxPower = $power;
		return $this;
	}
	
	/**
	 * @param integer $defense
	 * @throws \InvalidArgumentException
	 * @return Weapon
	 */
	public function setDefense($defense) {
		if (!is_numeric($defense)) {
			throw new \InvalidArgumentException('La fonction attend une puissance entière. Puissance donnée : '.var_dump($defense));
		}
		$this->defense = $defense;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getDamageType() {
		return $this->damageType;
	}
	
	/**
	 * @return number
	 */
	public function getMinPower() {
		return $this->minPower;
	}
	
	/**
	 * @return number
	 */
	public function getMaxPower() {
		return $this->maxPower;
	}
	
	/**
	 * @return integer|null
	 */
	public function getDefense() {
		return $this->defense;
	}

}
?>
