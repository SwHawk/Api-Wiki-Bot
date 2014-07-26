<?php

namespace SWHawkBot\Entities\Listeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SWHawkBot\Entities\BonusItem;
use SWHawkBot\Factories\ItemFactory;
use SWHawkBot\Entities\ItemAssociator;

class BonusItemListener
{
    public function prePersist(BonusItem $bItem, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();
        $upgradeComponentRepo = $em->getRepository("SWHawkBot\Entities\UpgradeComponent");
        $em->beginTransaction();
        try {
            if (!is_null(($ucId = $bItem->getUpgradeComponent1Id()))) {
                if (is_null(($component = $upgradeComponentRepo->findOneBy(array('gw2ApiId' => $ucId))))) {
                    $component = ItemFactory::returnItem($ucId);
                    $em->persist($component);
                    $componentAssociator = new ItemAssociator($component);
                    $em->persist($componentAssociator);
                    $bItem->setAssociator($componentAssociator);
                }
                $bItem->setUpgradeComponent1($component);
            }
            if (!is_null(($ucId = $bItem->getUpgradeComponent2Id()))) {
                if (is_null(($component = $upgradeComponentRepo->findOneBy(array('gw2ApiId' => $ucId))))) {
                    $component = ItemFactory::returnItem($ucId);
                    $em->persist($component);
                    $componentAssociator = new ItemAssociator($component);
                    $em->persist($componentAssociator);
                    $bItem->setAssociator($componentAssociator);
                }
                $bItem->setUpgradeComponent2($component);
            }
            $em->flush();
            $em->commit();
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }
}