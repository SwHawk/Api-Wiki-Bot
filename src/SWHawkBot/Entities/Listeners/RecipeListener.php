<?php

namespace SWHawkBot\Entities\Listeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SWHawkBot\Entities\Recipe;
use SWHawkBot\Factories\ItemFactory;
use SWHawkBot\Entities\ItemAssociator;

class RecipeListener
{
    public function prePersist(Recipe $recipe, LifecycleEventArgs $event)
    {
        $outputItemId = $recipe->getOutputItemId();
        $em = $event->getEntityManager();
        $associatorRepo = $em->getRepository("SWHawkBot\Entities\ItemAssociator");
        $associator = $associatorRepo->findOneBy(array('gw2ApiId' => $outputItemId));
        $em->beginTransaction();
        try {
            if (is_null($associator))
            {
                $item = ItemFactory::returnItem((int) $outputItemId);
                if (is_null($item)){
                    throw new \Exception("L'outputitem ayant pour id d'API : ".$outputItemId." n'est pas géré par la factory");
                }
                if (is_null($item->getType()))
                {
                    throw new \Exception("l'outputitem ayant pour id d'aPI : ".$outputItemId." n'a pas son type défini correctement");
                }
                $em->persist($item);
                $itemAssociator = new ItemAssociator($item);
                $em->persist($itemAssociator);
                $recipe->setOutputItemAssociator($itemAssociator);
            } else {
                $recipe->setOutputItemAssociator($associator);
            }
            $ingredientsId = array();
            for ($i = 1 ; $i < 5 ; $i++)
            {
                $ingredientGetter = "getMat".$i."Id";
                if (is_null($recipe->$ingredientGetter()))
                {
                    break;
                }
                array_push($ingredientsId, $recipe->$ingredientGetter());
            }
            foreach($ingredientsId as $ingredientNumber => $ingredientId)
            {
                $ingredientAssociator = $associatorRepo->findOneBy(array('gw2ApiId' => $ingredientId));
                if (is_null($ingredientAssociator))
                {
                    $ingredient = ItemFactory::returnItem((int) $ingredientId);
                    if (is_null($ingredient)){
                        throw new \Exception("L'ingredient ayant pour id d'API : ".$ingredientId." n'est pas géré par la factory");
                    }
                    if (is_null($ingredient->getType()))
                    {
                        throw new \Exception("l'ingredient ayant pour id d'aPI : ".$ingredientId." n'a pas son type défini correctement");
                    }
                    $em->persist($ingredient);
                    $ingredientAssociator = new ItemAssociator($ingredient);
                    $em->persist($ingredientAssociator);
                }
                $associatorSetter = "setMat".($ingredientNumber + 1)."Associator";
                $recipe->$associatorSetter($ingredientAssociator);
            }
            $em->flush();
            $em->commit();
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    public function postPersist(Recipe $recipe, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();
        $outputItemId = $recipe->getOutputItemId();
        $associatorRepo = $em->getRepository("SWHawkBot\Entities\ItemAssociator");
        $itemAssociator = $associatorRepo->findOneBy(array('gw2ApiId' => $outputItemId));
        $itemAssociator->addRecipe($recipe);
        for ($i = 1 ; $i < 5 ; $i++)
        {
            $ingredientAssociatorGetter = "getMat".$i."Associator";
            if (is_null($recipe->$ingredientAssociatorGetter()))
            {
                break;
            }
            $recipeAdder = "addMat".$i."Recipe";
            $recipe->$ingredientAssociatorGetter()->$recipeAdder($recipe);
        }
    }

    public function postLoad(Recipe $recipe, LifecycleEventArgs $event)
    {
        if (!is_null($recipe->getOutputItemAssociator()))
        {
            $item = $recipe->getOutputItemAssociator()->getRealItem();
            $recipe->setOutputItem($item);
        }
    }
}