<?php
namespace SWHawkBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use SWHawkBot\Constants;

/**
 * Cette classe *abstraite* représente un objet du jeu donnant des bonus aux
 * différentes caractéristiques d'un joueur.
 * Ces objets peuvent présenter 1 ou
 * 2 slots d'infusions et/ou 1 ou 2 slots de composants d'amélioration
 *
 * @author SwHawk
 *
 *         @ORM\MappedSuperClass
 *         @ORM\EntityListeners({"SWHawkBot\Entities\Listeners\BonusItemListener"})
 */
class BonusItem extends BuffItem
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
     * @var integer|null
     */
    protected $upgradeComponent1Id = null;


    /**
     * @ORM\ManyToOne(targetEntity="UpgradeComponent", cascade={"persist", "remove"})
     *
     * @var UpgradeComponent
     */
    protected $upgradeComponent1;

    /**
     * Identifiant du composant d'amélioration 2 pour l'API GuildWars2,
     * null si l'emplacement est vide
     *
     * @var integer|null
     */
    protected $upgradeComponent2Id = null;

    /**
     * @ORM\ManyToOne(targetEntity="UpgradeComponent", cascade={"persist", "remove"})
     *
     * @var UpgradeComponent
     */
    protected $upgradeComponent2;

    /**
     * Modificateur aux Dégats par altération donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $degatsAlterationModifier = null;

    /**
     * Modificateur à la Durée d'avantage donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $dureeAvantageModifier = null;

    /**
     * Modificateur à la Durée d'altération donné par l'objet
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer|null
     */
    protected $dureeAlterationModifier = null;

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
     * Constructeur
     *
     * @param array|null $item
     */
    public function __construct($item = null)
    {
        parent::__construct($item);

        $item_specific = $item[strtolower($item['type'])];

        if ($item['type'] == "UpgradeComponent")
        {
            $item_specific = $item['upgrade_component'];
        }

        $item_infusion_slots = $item_specific['infusion_slots'];
        if (is_array($item_infusion_slots) && count($item_infusion_slots)) {
            foreach ($item_infusion_slots as $number => $type) {
                $function = "setInfusionSlot" . ($number + 1) . "Type";
                $this->$function($type['flags'][0]);
            }
        }

        $item_infix_upgrade = $item_specific['infix_upgrade'];
        if (is_array($item_infix_upgrade) && count($item_infix_upgrade)) {
            if (isset($item_infix_upgrade['buff'])) {
                if ( in_array($item['type'], array('Armor', 'Trinket', 'UpgradeComponent', 'Weapon'))
                    && !stristr($this->getName(), 'cachet')
                    && !stristr($this->getName(), 'infusion')
                    && !stristr($this->getName(), 'rune')) {
                    $pregMatches = array();
                    if (preg_match_all("/(?'name'[\pL ']*) \+(?'modifier'\d{1,2})\%?/u",
                        $item_infix_upgrade['buff']['description'], $pregMatches, PREG_SET_ORDER)) {
                        foreach($pregMatches as $match)
                        {
                            if (array_key_exists($match['name'],
                                Constants::$translation['attributes_modifier_functions'])) {
                                    $modifierFunction = Constants::$translation['attributes_modifier_functions'][$match['name']];
                                    $this->$modifierFunction($match['modifier']);
                                }
                        }
                    } else {
                        $this->setBuffSkillId($item_infix_upgrade['buff']['skill_id']);
                        $this->setBuffSkillDescription($item_infix_upgrade['buff']['description']);
                    }
                } else {
                    $this->setBuffSkillId($item_infix_upgrade['buff']['skill_id']);
                    $this->setBuffSkillDescription($item_infix_upgrade['buff']['description']);
                }
            }
            if (isset($item_infix_upgrade['attributes']) && is_array($item_infix_upgrade['attributes']) && count($item_infix_upgrade['attributes'])) {
                foreach ($item_infix_upgrade['attributes'] as $attribute_array) {
                    if (array_key_exists($attribute_array['attribute'], Constants::$translation['attributes_modifier_functions'])) {
                        $function = Constants::$translation['attributes_modifier_functions'][$attribute_array['attribute']];
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

        if (isset($item_specific['suffix_item_id']) && $item_specific['suffix_item_id'] != "") {
            $this->setUpgradeComponent1Id($item_specific['suffix_item_id']);
        }
        if (isset($item_specific['secondary_suffix_item_id']) && $item_specific['secondary_suffix_item_id'] != "") {
            $this->setUpgradeComponent2Id($item_specific['second_suffix_item_id']);
        }
        return $this;
    }

    /**
     * Définit le type du premier slot
     * d'infusion
     *
     * @param string $type
     * @return BonusItem
     */
    public function setInfusionSlot1Type($type)
    {
        if (array_key_exists($type, Constants::$translation['infusion_types'])) {
            $this->infusionSlot1Type = Constants::$translation['infusion_types'][$type];
            return $this;
        }
        $this->infusionSlot1Type = $type;
        return $this;
    }

    /**
     * Définit le type du second slot
     * d'infusion
     *
     * @param string $type
     * @return \SWHawkBot\Entities\BonusItem
     */
    public function setInfusionSlot2Type($type)
    {
        if (array_key_exists($type, Constants::$translation['infusion_types'])) {
            $this->infusionSlot2Type = Constants::$translation['infusion_types'][$type];
            return $this;
        }
        $this->infusionSlot2Type = $type;
        return $this;
    }

    /**
     * Définit le modificateur aux dégâts par altération
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
     * Définit le modificateur à la durée des avantages
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
        $this->dureeAvantageModifier = $modifier;
        return $this;
    }

    /**
     * Définit le modificateur à la durée des altérations
     *
     * @param integer $modifier
     * @throws \InvalidArgumentException
     * @return BonusItem
     */
    public function setDureeAlterationModifier($modifier)
    {
        if (! is_numeric($modifier)) {
            throw new \InvalidArgumentException('La fonction attend un modifier entier. Modifier donné : ' . var_dump($modifier));
        }
        $this->dureeAlterationModifier = $modifier;
        return $this;
    }

    /**
     * Définit le modificateur à la férocité
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
     * Définit le modificateur à la guérison
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
     * Définit le modificateur à la précision
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
     * Définit le modificateur à la puissance
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
     * Définit le modificateur à la robustesse
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
     * Définit le modificateur à la vitalité
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
     * Définit l'identifiant auprès de l'API
     * GW2 du composant d'artisanat dans le premier
     * emplacement d'amélioration
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
     * Définit le composant d'artisanat présent
     * dans le premier emplacement d'amélioration
     *
     * @param UpgradeComponent $component
     * @return BonusItem
     */
    public function setUpgradeComponent1(UpgradeComponent $component)
    {
        $this->upgradeComponent1 = $component;
        return $this;
    }

    /**
     * Définit l'identifiant auprès de l'API
     * GW2 du composant d'artisanat dans le second
     * emplacement d'amélioration
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
     * Définit le composant d'artisanat présent
     * dans le second emplacement d'amélioration
     *
     * @param UpgradeComponent $component
     * @return \SWHawkBot\Entities\BonusItem
     */
    public function setUpgradeComponent2(UpgradeComponent $component)
    {
        $this->upgradeComponent2 = $component;
        return $this;
    }

    /**
     * Retourne le type du premier emplacement d'infusion
     * s'il existe
     *
     * @return string|null
     */
    public function getInfusionSlot1Type()
    {
        return $this->infusionSlot1Type;
    }

    /**
     * Retourne le type du second emplacement d'infusion
     * s'il existe
     *
     * @return string|null
     */
    public function getInfusionSlot2Type()
    {
        return $this->infusionSlot2Type;
    }

    /**
     * Renvoie l'identifiant, s'il existe,
     * auprès de l'API GW2 du composant
     * présent dans le premier emplacement
     * d'amélioration
     *
     * @return integer|null
     */
    public function getUpgradeComponent1Id()
    {
        return $this->upgradeComponent1Id;
    }

    /**
     * Renvoie le composant présent dans le premier
     * emplacement d'amélioration s'il existe
     *
     * @return UpgradeComponent|null
     */
    public function getUpgradeComponent1()
    {
        return $this->upgradeComponent1;
    }

    /**
     * Renvoie l'identifiant, s'il existe,
     * auprès de l'API GW2 du composant
     * présent dans le second emplacement
     * d'amélioration
     *
     * @return integer|null
     */
    public function getUpgradeComponent2Id()
    {
        return $this->upgradeComponent2Id;
    }

    /**
     * Renvoie le composant présent dans le second
     * emplacement d'amélioration s'il existe
     *
     * @return UpgradeComponent|null
     */
    public function getUpgradeComponent2()
    {
        return $this->upgradeComponent2;
    }

    /**
     * Renvoie le modificateur aux dégâts par
     * altération
     *
     * @return integer|null
     */
    public function getDegatsAlterationModifier()
    {
        return $this->degatsAlterationModifier;
    }

    /**
     * renvoie le modificateur à la durée des
     * avantages
     *
     * @return integer|null
     */
    public function getDureeAvantageModifier()
    {
        return $this->dureeAvantageModifier;
    }

    /**
     * Renvoie le modificateur à la durée
     * des altérations
     *
     * @return integer|null
     */
    public function getDureeAlterationModifier()
    {
        return $this->dureeAlterationModifier;
    }

    /**
     * Renvoie le modificateur à la férocité
     *
     * @return integer|null
     */
    public function getFerociteModifier()
    {
        return $this->ferociteModifier;
    }

    /**
     * Renvoie le modificateur à la guérison
     *
     * @return integer|null
     */
    public function getGuerisonModifier()
    {
        return $this->guerisonModifier;
    }

    /**
     * Renvoie le modificateur à la précision
     *
     * @return integer|null
     */
    public function getPrecisionModifier()
    {
        return $this->precisionModifier;
    }

    /**
     * Renvoie le modificateur à la puissance
     *
     * @return integer|null
     */
    public function getPuissanceModifier()
    {
        return $this->puissanceModifier;
    }

    /**
     * Renvoie le modificateur à la robustesse
     *
     * @return integer|null
     */
    public function getRobustesseModifier()
    {
        return $this->robustesseModifier;
    }

    /**
     * Renvoie le modificateur à la vitalité
     *
     * @return integer|null
     */
    public function getVitaliteModifier()
    {
        return $this->vitaliteModifier;
    }

}
