<?php

namespace SWHawkBot\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class RarityEnumType extends Type
{
    protected $name = 'rarityenum';

    protected $values = array(
        "Déchet",
        "Simple",
        "Raffiné",
        'Chef-d\'œuvre',
        "Rare",
        "Exotique",
        "Elevé",
        "Légendaire"
    );

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $values = array_map(function($val) { return "'".$val."'"; }, $this->values);

        return "ENUM('Déchet', 'Simple', 'Raffiné', 'Chef-d\'œuvre', 'Rare', 'Exotique', 'Elevé', 'Légendaire' ) COMMENT '(DC2Type:".$this->name.")'";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, $this->values)) {
            throw new \InvalidArgumentException("Rareté Invalide");
        }
        return $value;
    }

    public function getName()
    {
        return $this->name;
    }
}

?>