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
            if (is_null($associator->getGw2ApiId()))
            {
                $item = ItemFactory::returnItem($outputItemId);
                $em->persist($item);
                $itemAssociator = new ItemAssociator($item);
                $em->persist($itemAssociator);
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
                if (is_null($ingredientAssociator->getGw2ApiId()))
                {
                    $ingredient = ItemFactory::returnItem($ingredientId);
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
        $itemAssociator->getRealItem()->setRecipe($recipe);
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
}