<?php
/*
 *
 *
 */

namespace ProductReplacedBy\Smarty\Plugins;

use ProductReplacedBy\Model\ProductReplacedByQuery;
use ProductReplacedBy\ProductReplacedBy;
use TheliaSmarty\Template\AbstractSmartyPlugin;
use TheliaSmarty\Template\SmartyPluginDescriptor;

class SmartyProductReplacedBy extends AbstractSmartyPlugin
{

    /**
     * Check if product is replaced
     * @param $params
     * @return int
     */
    public function productIsReplacedBy($params)
    {
        $ret = '';
        $find = 'first';

        if (isset($params['find'])) {
            $find = $params['find'];
        }

        if (isset($params['product_id'])) {

            if ($find == 'first') {
               $ret = $this->checkProductReplacedBy($params['product_id']);
            }

            if ($find == 'all') {
                $ret_last = $this->checkProductReplacedBy($params['product_id']);
                while ($ret_last != '') {
                    $ret .= $ret_last.',';
                    $ret_last = $this->checkProductReplacedBy($ret_last);
                }
            }

            if ($find == 'last') {
                $ret_last = $this->checkProductReplacedBy($params['product_id']);
                while ($ret_last != '') {
                    $ret = $ret_last;
                    $ret_last = $this->checkProductReplacedBy($ret_last);
                }
            }

        }

        $ret = rtrim($ret,',');
        return $ret;
    }

    /**
     * Check if product is replaced
     * @param $product
     * @return int
     */
    private function checkProductReplacedBy($product)
    {
        $ret = '';
        $product_replaced_by_id = ProductReplacedByQuery::create()
            ->findOneByProductId($product);

        if (null !== $product_replaced_by_id) {
            $ret = $product_replaced_by_id->getReplacedById();
        }

        return $ret;
    }

    /**
     * @return SmartyPluginDescriptor[] an array of SmartyPluginDescriptor
     */
    public function getPluginDescriptors()
    {
        return array(
            new SmartyPluginDescriptor("function", "product_replaced_by", $this, "productIsReplacedBy")
        );
    }
}
