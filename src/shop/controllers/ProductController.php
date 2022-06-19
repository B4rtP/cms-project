<?php

use Cms\core\Controller;
use Cms\core\helpers\SessionHelper;
use Cms\shop\models\Product;

class ProductController extends Controller {

    public function indexAction() {

        $productId = $this->urlParams;

        if ($_POST['add-to-cart'] ?? false) {

            // Should be already created from index.php
            SessionHelper::createArray('cart');
            SessionHelper::addValue($productId, 'cart');
            header('Location:/shop');
            exit;
        }

        $product = new Product($this->dbc);
        $data['product'] = $product->findBy('id', $productId);

        $this->view->display('shop-product', $data);

    }
}