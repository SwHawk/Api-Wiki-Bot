<?php

require_once __DIR__.'/../bootstrap/doctrine-bootstrap.php';

$dql = "SELECT r FROM SWHawkBot\Entities\Recipe r JOIN r.outputItemAssociator ia WHERE ia.itemName LIKE :name1 OR ia.itemName LIKE :name2";

$recipes = $entityManager->createQuery($dql)->setParameter('name1', '%assiette%engrais%')->setParameter('name2', "%glaise%")->getResult();

foreach ($recipes  as $recipe)
{
	echo "Recette (".$recipe->getGw2ApiId().") de ".$recipe->getDisciplines()." pour : ".$recipe->getOutputItem()->getName()."\n".
		 "\t".$recipe->getMat1Qty()." x ".$recipe->getMat1()->getName()."\n".
		 "\t".$recipe->getMat2Qty()." x ".$recipe->getMat2()->getName()."\n".
		 "\t".$recipe->getMat3Qty()." x ".$recipe->getMat3()->getName()."\n".
		 "\t".$recipe->getMat4Qty()." x ".$recipe->getMat4()->getName()."\n";
}



?>
