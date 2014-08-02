<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use SWHawkBot\Entities\ItemAssociator;
use SWHawkBot\Entities\Trinket;
use Doctrine\Tests\Common\Annotations\TestAnnotationNotImportedClass;
require_once __DIR__.'/../bootstrap/doctrine-bootstrap.php';

$recipeRepo = $entityManager->getRepository("SWHawkBot\Entities\Recipe");

$copperAmulets = new ArrayCollection();

$dql = "SELECT r".
    " FROM SWHawkBot\Entities\Recipe r".
    " JOIN r.outputItemAssociator ia".
    " JOIN ia.trinket t".
    " WHERE r.difficulty BETWEEN 0 AND 50".
	   " AND r.type LIKE :type".
	" ORDER BY r.difficulty ASC, t.level ASC, t.name ASC, t.rarity ASC";

$copperAmuletRecipes2 = $entityManager->createQuery($dql)->setParameter('type','%amul%')->getResult();

foreach($copperAmuletRecipes2 as $recipe)
{
    $copperAmulets->add($recipe->getOutputItemAssociator()->getRealItem());
}

$copperAmuletsNames = array();



print_r($copperAmuletsNames);

print_r($copperItemsNames2);
?>