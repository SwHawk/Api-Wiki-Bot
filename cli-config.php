<?php
require_once __DIR__ . '/bootstrap/doctrine-bootstrap.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);

?>
