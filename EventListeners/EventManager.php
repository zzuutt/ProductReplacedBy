<?php
/**
 * User: Zzuutt
 * Date: 14/06/2018
 * Time: 10:11
 */
namespace ProductReplacedBy\EventListeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ProductReplacedBy\Model\ProductReplacedByQuery;
use ProductReplacedBy\ProductReplacedBy;
use Thelia\Core\Event\ActionEvent;
use Thelia\Core\Event\Product\ProductDeleteEvent;
use Thelia\Core\Event\Product\ProductEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\TheliaFormEvent;
use Thelia\Core\Translation\Translator;
use Thelia\Tools\URL;

class EventManager implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::PRODUCT_DELETE  => [ 'deleteProduct' ],

            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_product_creation" => ['addFieldToForm', 128],
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_product_modification" => ['addFieldToForm', 128],

            TheliaEvents::PRODUCT_UPDATE  => ['processProductFields', 100],
            TheliaEvents::PRODUCT_CREATE  => ['processProductFields', 100],
        ];
    }

    public function addFieldToForm(TheliaFormEvent $event)
    {
        $event->getForm()->getFormBuilder()->add(
            'replaced_by_id',
            'integer',
            [
                'required' => false,
                'label' => Translator::getInstance()->trans(
                    'Product replaced by',
                    [],
                    ProductReplacedBy::MESSAGE_DOMAIN
                ),
                'label_attr'  => [
                    'help' => Translator::getInstance()->trans(
                        'Select the product that comes in replacement',
                        [],
                        ProductReplacedBy::MESSAGE_DOMAIN
                    )
                ]
            ]
        );
    }

    public function processProductReplacedBy(ActionEvent $event, $productId)
    {
        // Utilise le principe NON DOCUMENTE qui dit que si une form bindée à un event trouve
        // un champ absent de l'event, elle le rend accessible à travers une méthode magique.
        // (cf. ActionEvent::bindForm())
        $product_replaced_by_id = $event->replaced_by_id;

        // Delete existing values
        ProductReplacedByQuery::create()->filterByProductId($productId)->delete();

        if (! empty($product_replaced_by_id)) {
                $product_replaced = new \ProductReplacedBy\Model\ProductReplacedBy();
                $product_replaced->setProductId($productId)->setReplacedById($product_replaced_by_id)->save();
        }

    }

    public function processProductFields(ProductEvent $event)
    {
        if ($event->hasProduct()) {
            $this->processProductReplacedBy($event, $event->getProduct()->getId());
        }
    }

    public function deleteProduct(ProductDeleteEvent $event)
    {
        ProductReplacedByQuery::create()->filterByProductId($event->getProductId())->delete();
    }

}
