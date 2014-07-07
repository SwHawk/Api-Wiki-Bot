<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cette classe *abstraite* représente un objet du jeu donnant des bonus aux
 * différentes caractéristiques d'un joueur.
 * Ces objets peuvent présenter 1 ou
 * 2 slots d'infusions ou 1 ou 2 slots de composants d'amélioration
 *
 * @author SwHawk
 *        
 *         @ORM\MappedSuperClass
 */
class BonusItem extends Item
{

    /**
     * Type d'infusion à placer dans le slot 1,
     * null si l'emplacement est vide
     *
     * Valeurs possibles : Défensive, Offensive, Utilitaire
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    protected $infusionSlot1Type = null;

    /**
     * Type d'infusion à placer dans le slot 2,
     * null si l'emplacement est vide
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    protected $infusionSlot2Type = null;

    /**
     * Identifiant du composant d'amélioration 1 pour l'API GuildWars2,
     * null si l'emplacement est vide
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $upgradeComponent1Id = null;

    /**
     * Identifiant du composant d'amélioration 2 pour l'API GuildWars2,
     * null si l'emplacement est vide
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $upgradeComponent2Id = null;

    /**
     * Modificateur aux Dégats par altération donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $degatsAlterationModifier = null;

    /**
     * Modificateur à la Durée des Avantages donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $dureeAvantagesModifier = null;

    /**
     * Modificateur à la Férocité donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $ferociteModifier = null;

    /**
     * Modificateur à la Guérison donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $guerisonModifier = null;

    /**
     * Modificateur à la Précision donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $precisionModifier = null;

    /**
     * Modificateur à la Puissance donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $puissanceModifier = null;

    /**
     * Modificateur à la Robustesse donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $robustesseModifier = null;

    /**
     * Modificateur à la Vitalité donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $vitaliteModifier = null;

    /**
     * Identifiant du skill de buff de l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|nullc
     */
    protected $buffSkillId = null;

    /**
     * Description du skill de buff de l'objet
     *
     * @ORM\column(type="text", nullable=true)
     *
     * @var string|null
     */
    protected $buffSkillDescription = null;

    /**
     * Correspondances API/wiki-fr bonus
     */
    const API_TYPE_CONDITION_DAMAGE = "ConditionDamage";

    const TYPE_CONDITION_DAMAGE = "setDegatsAlterationModifier";

    const API_TYPE_CRITICAL_DAMAGE = "CritDamage";

    const TYPE_CRITICAL_DAMAGE = "setFerociteModifier";

    const API_TYPE_HEALING = "Healing";

    const TYPE_HEALING = "setGuerisonModifier";

    const API_TYPE_POWER = "Power";

    const TYPE_POWER = "setPuissanceModifier";

    const API_TYPE_PRECISION = "Precision";

    const TYPE_PRECISION = "setPrecisionModifier";

    const API_TYPE_TOUGHNESS = "Toughness";

    const TYPE_TOUGHNESS = "setRobustesseModifier";

    const API_TYPE_VITALITY = "Vitality";

    const TYPE_VITALITY = "setVitaliteModifier";

    /**
     * Correspondances API/wiki-fr types d'infusions
     */
    const API_TYPE_DEFENSE = "Defense";

    const TYPE_DEFENSE = "Défensive";

    const API_TYPE_OFFENSE = "Offense";

    const TYPE_OFFENSE = "Offensive";

    const API_TYPE_UTILITARY = "Utilitary";

    const TYPE_UTILITARY = "Utilitaire";

    /**
     * Constructeur
     *
     * @param array|null $item            
     */
    public function __construct($item = null)
    {
        parent::__construct($item);
        
        $item_specific = $item[strtolower($item['type'])];
        
        $item_infusion_slots = $item_specific['infusion_slots'];
        if (is_array($item_infusion_slots) && count($item_infusion_slots)) {
            foreach ($item_infusion_slots as $number => $type) {
                $function = "setInfusionSlot" . ($number + 1) . "Type";
                $this->$function($type);
            }
        }
        
        $item_infix_upgrade = $item_specific['infix_upgrade'];
        if (is_array($item_infix_upgrade) && count($item_infix_upgrade)) {
            if (isset($item_infix_upgrade['buff'])) {
                $this->setBuffSkillId($item_infix_upgrade['buff']['skill_id']);
                $this->setBuffSkillDescription($item_infix_upgrade['buff']['description']);
            }
            if (isset($item_infix_upgrade['attributes']) && is_array($item_infix_upgrade['attributes']) && count($item_infix_upgrade['attributes'])) {
                foreach ($item_infix_upgrade['attributes'] as $attribute_array) {
                    if ($attribute_array['attribute'] == self::API_TYPE_CONDITION_DAMAGE) {
                        $function = self::TYPE_CONDITION_DAMAGE;
                    }
                    if ($attribute_array['attribute'] == self::API_TYPE_CRITICAL_DAMAGE) {
                        $function = self::TYPE_CRITICAL_DAMAGE;
                    }
                    if ($attribute_array['attribute'] == self::API_TYPE_HEALING) {
                        $function = self::TYPE_HEALING;
                    }
                    if ($attribute_array['attribute'] == self::API_TYPE_POWER) {
                        $function = self::TYPE_POWER;
                    }
                    if ($attribute_array['attribute'] == self::API_TYPE_PRECISION) {
                        $function = self::TYPE_PRECISION;
                    }
                    if ($attribute_array['attribute'] == self::API_TYPE_TOUGHNESS) {
                        $function = self::TYPE_TOUGHNESS;
                    }
                    if ($attribute_array['attribute'] == self::API_TYPE_VITALITY) {
                        $function = self::TYPE_VITALITY;
                    }
                    try {
                        $this->$function($attribute_array['modifier']);
                    } catch (\InvalidArgumentException $e) {
                        echo "Erreur lors de l'appel à la fonction " . $function . " : " . $e->getMessage() . ".\n";
                        echo "La version raw de l'item était : \n" . var_dump($item);
                    }
                }
            }
        }
        
        if (isset($item_specific['suffix_item_id'])) {
            $this->setUpgradeComponent1Id($item_specific['suffix_item_id']);
        }
        if (isset($item_specific['secondary_suffix_item_id'])) {
            $this->setUpgradeComponent2Id($item_specific['second_suffix_item_id']);
        }
    }

    /**
     *
     * @param string $type            
     * @return BonusItem
     */
    public function setInfusionSlot1Type($type)
    {
        if ($type == self::API_TYPE_DEFENSE) {
            $this->infusionSlot1Type = self::TYPE_DEFENSE;
            return $this;
        }
        if ($type == self::API_TYPE_OFFENSE) {
            $this->infusionSlot1Type = self::TYPE_DEFENSE;
            return $this;
        }
        if ($type == self::API_TYPE_UTILITARY) {
            $this->infusionSlot1Type = self::TYPE_UTILITARY;
        }
    }

    /**
     *
     * @param string $type            
     * @return \SWHawkBot\Entities\BonusItem
     */
    public function setInfusionSlot2Type($type)
    {
        if ($type == self::API_TYPE_DEFENSE) {
            $this->infusionSlot2Type = self::TYPE_DEFENSE;
            return $this;
        }
        if ($type == self::API_TYPE_OFFENSE) {
            $this->infusionSlot2Type = self::TYPE_DEFENSE;
            return $this;
        }
        if ($type == self::API_TYPE_UTILITARY) {
            $this->infusionSlot2Type = self::TYPE_UTILITARY;
        }
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setDegatsAlterationModifier($modifier)
    {
        if (! is_numeric($modifier)) {
            throw new \InvalidArgumentException('La fonction attend un modifier entier. Modifier donné : ' . var_dump($modifier));
        }
        $this->degatsAlterationModifier = $modifier;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setDureeAvantageModifier($modifier)
    {
        if (! is_numeric($modifier)) {
            throw new \InvalidArgumentException('La fonction attend un modifier entier. Modifier donné : ' . var_dump($modifier));
        }
        $this->dureeAvantagesModifier = $modifier;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setFerociteModifier($modifier)
    {
        if (! is_numeric($modifier)) {
            throw new \InvalidArgumentException('La fonction attend un modifier entier. Modifier donné : ' . var_dump($modifier));
        }
        $this->ferociteModifier = $modifier;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setGuerisonModifier($modifier)
    {
        if (! is_numeric($modifier)) {
            throw new \InvalidArgumentException('La fonction attend un modifier entier. Modifier donné : ' . var_dump($modifier));
        }
        $this->guerisonModifier = $modifier;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setPrecisionModifier($modifier)
    {
        if (! is_numeric($modifier)) {
            throw new \InvalidArgumentException('La fonction attend un modifier entier. Modifier donné : ' . var_dump($modifier));
        }
        $this->precisionModifier = $modifier;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setPuissanceModifier($modifier)
    {
        if (! is_numeric($modifier)) {
            throw new \InvalidArgumentException('La fonction attend un modifier entier. Modifier donné : ' . var_dump($modifier));
        }
        $this->puissanceModifier = $modifier;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setRobustesseModifier($modifier)
    {
        if (! is_numeric($modifier)) {
            throw new \InvalidArgumentException('La fonction attend un modifier entier. Modifier donné : ' . var_dump($modifier));
        }
        $this->robustesseModifier = $modifier;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setVitaliteModifier($modifier)
    {
        if (! is_numeric($modifier)) {
            throw new \InvalidArgumentException('La fonction attend un modifier entier. Modifier donné : ' . var_dump($modifier));
        }
        $this->vitaliteModifier = $modifier;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setBuffSkillId($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException('La fonction attend un id entier. Id donné : ' . var_dump($id));
        }
        $this->buffSkillId = $id;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setBuffSkillDescription($description)
    {
        $this->buffSkillDescription = $description;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setUpgradeComponent1Id($id)
    {
        if (! is_numeric($id) && $id != "") {
            throw new \InvalidArgumentException('La fonction attend un id entier ou null. Id donné : ' . var_dump($id));
        }
        $this->upgradeComponent1Id = $id;
        return $this;
    }

    /**
     *
     * @param integer $modifier            
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setUpgradeComponent2Id($id)
    {
        if (! is_numeric($id) && $id != "") {
            throw new \InvalidArgumentException('La fonction attend un id entier ou null. Id donné : ' . var_dump($id));
        }
        $this->upgradeComponent2Id = $id;
        return $this;
    }

    /**
     *
     * @return integer|null
     */
    public function getUpgradeComponent1Id()
    {
        return $this->upgradeComponent1Id;
    }

    /**
     *
     * @return integer|null
     */
    public function getUpgradeComponent2Id()
    {
        return $this->upgradeComponent2Id;
    }

    /**
     *
     * @return integer|null
     */
    public function getDegatsAlterationModifier()
    {
        return $this->degatsAlterationModifier;
    }

    /**
     *
     * @return integer|null
     */
    public function getDureeAvantageModifier()
    {
        return $this->dureeAvantagesModifier;
    }

    /**
     *
     * @return integer|null
     */
    public function getFerociteModifier()
    {
        return $this->ferociteModifier;
    }

    /**
     *
     * @return integer|null
     */
    public function getGuerisonModifier()
    {
        return $this->guerisonModifier;
    }

    /**
     *
     * @return integer|null
     */
    public function getPrecisionModifier()
    {
        return $this->precisionModifier;
    }

    /**
     *
     * @return integer|null
     */
    public function getPuissanceModifier()
    {
        return $this->puissanceModifier;
    }

    /**
     *
     * @return integer|null
     */
    public function getRobustesseModifier()
    {
        return $this->robustesseModifier;
    }

    /**
     *
     * @return integer|null
     */
    public function getVitaliteModifier()
    {
        return $this->vitaliteModifier;
    }

    /**
     *
     * @return integer|null
     */
    public function getBuffSkillId()
    {
        return $this->buffSkillId;
    }

    /**
     *
     * @return string|null
     */
    public function getBuffSkillDescription()
    {
        return $this->buffSkillDescription;
    }
}
