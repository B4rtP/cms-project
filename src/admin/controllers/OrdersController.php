<?php

use Cms\core\Controller;
use Cms\shop\models\Order;
use Cms\shop\models\Product;
use Cms\shop\models\ShippingProvider;

class OrdersController extends Controller {

    public function indexAction() {

        $order = new Order($this->dbc);
        $data['orders'] = $order->findAll();

        $this->view->display('list-orders', $data);

    }

    public function detailsAction() {

        $orderInst = new Order($this->dbc);
        $shippingProviderInst = new ShippingProvider($this->dbc);

        $order = $orderInst->findBy('order_id', $this->id);

        $data['order'] = $order;

        $data['shipProvider'] = $shippingProviderInst->findBy(
            'id', $order->shipping_provider_id);
        
        $productsString = '';
        $idAndCountProducts = json_decode($order->products);
        foreach ($idAndCountProducts as $productId => $count) {
            $productsString .= $count.'x '. $productId.', ';
        }

        $data['orderProducts'] = rtrim($productsString, ', ');

        $this->view->display('order-details', $data);
    }

    public function inspectOrderProductsAction() {

        $productInst = new Product($this->dbc);
        $orderInst = new Order($this->dbc);
        $order = $orderInst->findBy('order_id', $this->id);
        
        $productIdAndCount = json_decode($order->products, true);
        $productsId = array_keys($productIdAndCount);
        $data['products'] = $productInst->findAllBy('id', $productsId);
        $data['productIdAndCount'] = $productIdAndCount;
        $data['orderId'] = $this->id;
        
        $this->view->display('inspect-order-products', $data);
    }
}