<?php

namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle de données des pièces d'armures de GuildWars 2
 * 
 * @author SwHawk
 * 
 * @ORM\Entity @ORM\Table(name="Armorpieces")
 */
class Armor extends BonusItem {

	/**
	 * Classe d'armure de la pièce
	 * 
	 * Valeur possibles : Intermédiaire, Léger, Lourd
	 * 
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $weightClass;
	
	/**
	 * Défense octroyée par la pièce d'armure
	 * 
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	protected $defense;
	
	/**
	 * Correspondances API/wiki-fr Classes d'armures
	 */
	const API_TYPE_HEAVY = "Heavy";
	const TYPE_HEAVY = "Lourd";
	const API_TYPE_MEDIUM = "Medium";
	const TYPE_MEDIUM = "Intermédiaire";
	const API_TYPE_LIGHT = "Light";
	const TYPE_LIGHT = "Léger";
	
	/**
	 * Correspondances API/wiki-fr Types d'armure
	 */
	const API_TYPE_BOOTS = "Boots";
	const TYPE_BOOTS = "Botte";
	const API_TYPE_COAT = "Coat";
	const TYPE_COAT = "Manteau";
	const API_TYPE_GLOVES = "Gloves";
	const TYPE_GLOVES = "Gant";
	const API_TYPE_HELM = "Helm";
	const TYPE_HELM = "Heaume";
	const API_TYPE_HELMAQUATIC = "HelmAquatic";
	const TYPE_HELMAQUATIC = "Heaume";
	const API_TYPE_LEGGINGS = "Leggings";
	const TYPE_LEGGINGS = "Jambière";
	const API_TYPE_SHOULDERS = "Shoulders";
	const TYPE_SHOULDERS = "Epaulière";

	/**
	 * Constructeur de la classe, faisant appel aux
	 * constructeurs des classes parentes
	 * 
	 * @param array|null $armor
	 * @return Armor
	 */
    public function __construct($armor = null) {
		parent::__construct($armor);
		$armor_specific = $armor['armor'];
		
		$this->setType($armor_specific['type']);
		
		$this->setWeightClass($armor_specific['weight_class']);
		
		$this->setDefense($armor_specific['defense']);

		return $this;
	}
	
	/**
	 * @param string $class
	 * @return Armor
	 */
	public function setWeightClass($class) {
		if ($class == self::API_TYPE_HEAVY || $class == self::TYPE_HEAVY) {
			$this->weightClass = self::TYPE_HEAVY;
			return $this;
		}
		if ($class == self::API_TYPE_LIGHT || $class == self::TYPE_LIGHT) {
			$this->weightClass = self::TYPE_LIGHT;
			return $this;
		}
		if ($class == self::API_TYPE_MEDIUM || $class == self::TYPE_MEDIUM) {
			$this->weightClass = self::TYPE_MEDIUM;
			return $this;
		}
	}
	
	/**
	 * @see \SWHawkBot\Entities\Item::setType()
	 */
	public function setType($type) {
		if ($type == self::API_TYPE_BOOTS || $type == self::TYPE_BOOTS) {
			$this->type = self::TYPE_BOOTS;
			return $this;
		}
		if ($type == self::API_TYPE_COAT || $type == self::TYPE_COAT) {
			$this->type = self::TYPE_COAT;
			return $this;
		}
		if ($type == self::API_TYPE_GLOVES || $type == self::TYPE_GLOVES) {
			$this->type = self::TYPE_GLOVES;
			return $this;
		}
		if ($type == self::API_TYPE_HELM || $type == self::TYPE_HELM) {
			$this->type = self::TYPE_HELM;
			return $this;
		}
		if ($type == self::API_TYPE_HELMAQUATIC || $type == self::TYPE_HELMAQUATIC) {
			$this->type = self::TYPE_HELMAQUATIC;
			return $this;
		}
		if ($type == self::API_TYPE_LEGGINGS || $type == self::TYPE_LEGGINGS) {
			$this->type = self::TYPE_LEGGINGS;
			return $this;
		}
		if ($type == self::API_TYPE_SHOULDERS || $type == self::TYPE_SHOULDERS) {
			$this->type = self::TYPE_SHOULDERS;
			return $this;
		}
	}
		
	/**
	 * @param integer $defense
	 * @throws \InvalidArgumentException
	 * @return Armor
	 */
	public function setDefense($defense) {
		if (!is_numeric($defense)) {
			throw new \InvalidArgumentException('La fonction attend une défense entière. Défense donnée : '.var_dump($defense));
		}
		$this->defense = $defense;
		return $this;
	}
	
	/**
	 * @return integer
	 */
	public function getDefense() {
		return $this->defense;
	}
	
	/**
	 * @return string
	 */
	public function getWeightClass() {
		return $this->weightClass;
	}
		
}

?>
