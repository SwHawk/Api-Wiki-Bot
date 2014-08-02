<?php

require_once __DIR__.'/../bootstrap/doctrine-bootstrap.php';

use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Output\ConsoleOutput;

$craftingMaterials = $entityManager->getRepository('SWHawkBot\Entities\CraftingMaterial')->findAll();

$cmNumber = count($craftingMaterials);

$cyclesNumber = (int) ($cmNumber/100) + 1;

$console = new ConsoleOutput();

$progress = new ProgressHelper();

$progress->setFormat(ProgressHelper::FORMAT_VERBOSE);

$progress->start($console, $cmNumber);

for ( $i = 0 ; $i <= $cyclesNumber ; $i++ )
{
    if ($i) {
        $entityManager->close();
    }
    $entityManager = EntityManager::create($yamlDoctrineConfig['config'], $config);
        for ( $j = 0 ; $j < 100 ; $j++ )
        {
            $index = 100*$i + $j;
            if ($index > $cmNumber -1) {
                break;
            }
            $cm = $craftingMaterials[100*$i + $j];
            $prerequisites = array();
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
}

$entityManager->close();
$progress->finish();

?>

