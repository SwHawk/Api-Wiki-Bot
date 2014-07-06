<?php

require_once "bootstrap/doctrine-bootstrap.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);

?>
