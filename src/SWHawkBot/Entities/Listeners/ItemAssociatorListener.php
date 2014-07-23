<?php

namespace SWHawkBot\Entities\Listeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SWHawkBot\Entities\ItemAssociator;

class ItemAssociatorListener
{
    public function postLoad(ItemAssociator $associator, LifecycleEventArgs $event)
    {
        if (!is_null($associator->getArmorpiece()))
        {
            $item = $associator->getArmorpiece();
        }

        if (!is_null($associator->getBack()))
        {
            $item = $associator->getBack();
        }

        if (!is_null($associator->getBag()))
        {
            $item = $associator->getBag();
        }

        if (!is_null($associator->getConsumable()))
        {
            $item = $associator->getConsumable();
        }

        if (!is_null($associator->getContainer()))
        {
            $item = $associator->getContainer();
        }

        if (!is_null($associator->getCraftingMaterial()))
        {
            $item = $associator->getCraftingMaterial();
        }

        if (!is_null($associator->getTrinket()))
        {
            $item = $associator->getTrinket();
        }

        if (!is_null($associator->getTrophy()))
        {
            $item = $associator->getTrophy();
        }

        if (!is_null($associator->getUpgradeComponent()))
        {
            $item = $associator->getUpgradeComponent();
        }

        if (!is_null($associator->getWeapon()))
        {
            $item = $associator->getWeapon();
        }

        $associator->setRealItem($item);

            if (!$associator->getMat1Recipes()->count())
        {
            foreach($associator->getMat1Recipes() as $recipe)
            {
                $associator->getRealItem()->addRecipeUsedIn($recipe);
            }
        }

        if (!$associator->getMat2Recipes()->count())
        {
            foreach($associator->getMat2Recipes() as $recipe)
            {
                $associator->getRealItem()->addRecipeUsedIn($recipe);
            }
        }

        if (!$associator->getMat3Recipes()->count())
        {
            foreach($associator->getMat3Recipes() as $recipe)
            {
                $associator->getRealItem()->addRecipeUsedIn($recipe);
            }
        }

        if (!$associator->getMat4Recipes()->count())
        {
            foreach($associator->getMat4Recipes() as $recipe)
            {
                $associator->getRealItem()->addRecipeUsedIn($recipe);
            }
        }


    }
}