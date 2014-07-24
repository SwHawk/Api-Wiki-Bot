<?php

namespace SWHawkBot\Entities\Listeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SWHawkBot\Entities\Item;

class ItemListener
{
    public function postLoad(Item $item, LifecycleEventArgs $event)
    {
        $associator = $item->getAssociator();
        foreach ($associator->getRecipes() as $recipe)
        {
            $item->addRecipe($recipe);
        }
        for ($i = 1 ; $i <= 4 ; $i++)
        {
            $recipesGetter = "getMat".$i."Recipes";
            if (!$associator->$recipesGetter()->isEmpty())
            {
                foreach ($associator->$recipesGetter() as $recipe)
                {
                    $item->addRecipeUsedIn($recipe);
                }
            }
        }

    }
}