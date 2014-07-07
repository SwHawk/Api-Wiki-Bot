<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

require_once __DIR__ . '/../vendor/autoload.php';

$isDevMode = true;

$config = Setup::createAnnotationMetadataConfiguration(array(
    __DIR__ . "/src/SWHawkBot/Entities"
), $isDevMode, null, null, false);

$conn = array(
    'driver' => 'pdo_mysql',
    'user' => 'xxxxxxxxx',
    'password' => 'xxxxxxxxxxxx',
    'dbname' => 'xxxxxxxxxxx',
    'host' => 'xxxxxxxxxxxx',
    'charset' => 'utf8'
);

$entityManager = EntityManager::create($conn, $config);
?>
