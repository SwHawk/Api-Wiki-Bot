<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Yaml\Parser;
use Doctrine\DBAL\Types\Type;

require_once __DIR__ . '/../vendor/autoload.php';

setlocale(LC_ALL, "fr_FR.utf8");

$isDevMode = true;

$config = Setup::createAnnotationMetadataConfiguration(array(
    __DIR__ . "/../src/SWHawkBot/Entities"
), $isDevMode, null, null, false);

$config->setNamingStrategy(new Doctrine\ORM\Mapping\UnderscoreNamingStrategy());

$memcached = new \Memcached();
$memcached->addServer('127.0.0.1',11211);

$cacheImpl = new Doctrine\Common\Cache\MemcachedCache();
$cacheImpl->setMemcached($memcached);

$config->setMetadataCacheImpl($cacheImpl);
$config->setQueryCacheImpl($cacheImpl);
$config->setResultCacheImpl($cacheImpl);
Type::addType('rarityenum', 'SWHawkBot\DBAL\Types\RarityEnumType');

$yamlParser = new Parser();

$yamlDoctrineConfig = $yamlParser->parse(file_get_contents(__DIR__ . '/../config/config.yaml'));

$entityManager = EntityManager::create($yamlDoctrineConfig['config'], $config);
?>
