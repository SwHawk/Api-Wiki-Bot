<?php

require_once __DIR__.'/../bootstrap/doctrine-bootstrap.php';

use SWHawkBot\GW2ApiBot\GW2RecipeBot;
use Doctrine\ORM\EntityManager;
use SWHawkBot\Entities\Recipe;
use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Output\ConsoleOutput;

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);

$recipeBot = GW2RecipeBot::getRecipeBotInstance("1","fr",3);

$recipes = $recipeBot->getRecipesIds();
sort($recipes);

$recipesPerCycle = 50;

$recipesNumber = count($recipes);
$cyclesNumber = (int)($recipesNumber/$recipesPerCycle) + 1;

$console = new ConsoleOutput();

$progress = new ProgressHelper();

$progress->setFormat(ProgressHelper::FORMAT_VERBOSE);
$progress->setBarCharacter("<info>=</info>");
$progress->setEmptyBarCharacter("<comment>-</comment>");

echo "Ajout des recettes en base de données :\n";
$progress->start($console, $recipesNumber);

for ( $i = 0 ; $i <= $cyclesNumber ; $i++) {
    if ($i) {
        $entityManager->getConnection()->close();
        $entityManager->close();
    }
    $entityManager = EntityManager::create($yamlDoctrineConfig['config'], $config);
    $recipeRepo = $entityManager->getRepository("SWHawkBot\Entities\Recipe");
    $entityManager->beginTransaction();
    try {
        for ( $j = 0 ; $j < $recipesPerCycle ; $j++ ) {
            if ($recipesPerCycle*$i + $j > $recipesNumber - 1) {
                break;
            }
            $recipeId = $recipes[$recipesPerCycle*$i + $j];
            if ( ($recipeId < 9637 || $recipeId > 9660)
                && is_null($recipeRepo->findOneBy(array('gw2ApiId' => $recipeId)))) {
                    $recipeRaw = $recipeBot->getRecipeRaw($recipeId);
                    $recipe = new Recipe($recipeRaw);
                    $entityManager->persist($recipe);
            }
            $progress->advance();
        }
        $entityManager->flush();
        $entityManager->commit();
    } catch (\Exception $e) {
        $entityManager->rollback();
        throw $e;
    }
}

$entityManager->close();
$progress->finish();

echo "Mise à jour des pré-requis pour les composants d'artisanat :\n";

$craftingMaterials = $entityManager->getRepository('SWHawkBot\Entities\CraftingMaterial')->findAll();
$cmNumber = count($craftingMaterials);

$cyclesNumber = (int) ($cmNumber/100) + 1;

$progress->start($console, $cmNumber);

for ( $i = 0 ; $i <= $cyclesNumber ; $i++ )
{
    $entityManager = EntityManager::create($yamlDoctrineConfig['config'], $config);
    $entityManager->beginTransaction();
    try {
        for ( $j = 0 ; $j < 100 ; $j++ )
        {
            $index = 100*$i + $j;
            if ($index > $cmNumber -1) {
                break;
            }
            $cm = $craftingMaterials[100*$i + $j];
            if (count($cm->getPrerequisites()))
            {
                $prerequisites = $cm->getPrerequisites();
            } else {
                $prerequisites = array();
            }
            $recipesCMUsedIn = $cm->getRecipesUsedIn();
            foreach ($recipesCMUsedIn as $recipe)
            {
                $disciplines = explode(', ', $recipe->getDisciplines());
                foreach($disciplines as $discipline)
                {
                    if (!array_key_exists($discipline, $prerequisites)) {
                        $prerequisites[$discipline] = $recipe->getDifficulty();
                    } elseif ($recipe->getDifficulty() < $prerequisites[$discipline]) {
                        $prerequisites[$discipline] = $recipe->getDifficulty();
                    }
                }
            }
            $cm->setPrerequisites($prerequisites);
            $progress->advance();
            $entityManager->merge($cm);
        }
        $entityManager->flush();
        $entityManager->commit();
    } catch (\Exception $e) {
        $entityManager->rollback();
        throw $e;
    }
    $entityManager->close();
}
$progress->finish();

?>
