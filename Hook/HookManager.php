<?php
/**
 * @author zzuutt <zzuutt34@free.fr>
 *
 * Creation date: 14/06/2018
 */

namespace ProductReplacedBy\Hook;

use ProductReplacedBy\Model\ProductReplacedBy;
use Propel\Runtime\ActiveQuery\Criteria;
use ProductReplacedBy\Model\ProductReplacedByQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ProductQuery;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class HookManager extends BaseHook
{
    private function processFieldHook(HookRenderEvent $event, $productId)
    {
        $obj = ProductQuery::create()->findPks($productId);

        $category = CategoryQuery::create()
            ->filterByProduct($obj, Criteria::IN)
            ->findOne();

        $categoryParent = $category->getParent();

        $productReplacedBy = ProductReplacedByQuery::create()
            ->filterByProductId($productId)
            ->findOne();

        $event->add(
            $this->render(
                "productReplacedBy-includes/generic-definition.html",
                [
                    'product_replaced' => $productReplacedBy ? $productReplacedBy->getReplacedById():'',
                    'category_parent' => $categoryParent,
                    'product_id' => $productId
                ]
            )
        );
    }

    /**
    public function onModuleConfiguration(HookRenderEvent $event)
    {
        $event->add(
            $this->render("productReplacedBy-includes/module-configuration.html")
        );
    }
     */

    public function onProductEditRightColumnBottom(HookRenderEvent $event)
    {
        $this->processFieldHook($event, $event->getArgument('product_id'));
    }

}
