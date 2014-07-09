<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Yaml\Parser;

require_once __DIR__ . '/../vendor/autoload.php';

$isDevMode = true;

$config = Setup::createAnnotationMetadataConfiguration(array(
    __DIR__ . "/src/SWHawkBot/Entities"
), $isDevMode, null, null, false);

$yamlParser = new Parser();

$yamlDoctrineConfig = $yamlParser->parse(file_get_contents(__DIR__ . '/../config/doctrine-config.yaml'));

$entityManager = EntityManager::create($yamlDoctrineConfig['config'], $config);
?>
