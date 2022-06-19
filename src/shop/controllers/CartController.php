<?php

use Cms\core\Controller;
use Cms\core\helpers\SessionHelper;
use Cms\models\Page;
use Cms\shop\models\Product;

class CartController extends Controller {

    public function indexAction() {
        
        $page = new Page($this->dbc);
        $data['page'] = $page->findBy('id', $this->entityId);

        if($_POST['plus'] ?? false) {

            $productId = $_POST['plus'];
            SessionHelper::addValue($productId, 'cart');
        }

        if ($_POST['minus'] ?? false) {

            $productId = $_POST['minus'];
            SessionHelper::unsetByValue($productId, 'cart');
        }

        if($_POST['delete'] ?? false) {

            $productId = $_POST['delete'];
            SessionHelper::unsetAllByValue($productId, 'cart');
        }
        
        if(SessionHelper::containsValue('cart') ?? false) {
            
            $product = new Product($this->dbc);

            $data['products'] =
            $product->findAllBy('id', SessionHelper::getUniqueValues('cart'));

            $data['itemCount'] = SessionHelper::count('cart') == 1 ? '1 item'
            : SessionHelper::count('cart') . ' items';

            $data['quantity'] = SessionHelper::countUniqueValues('cart');

            $subtotal = 0;
            foreach (SessionHelper::countUniqueValues('cart') as $id => $count) {
                $singleProduct = $product->findBy('id', $id);
                $subtotal += $singleProduct->price * $count;
            }
            SessionHelper::createOrOverwrite('subtotal', $subtotal);
            $data['subtotal'] = $subtotal;
        }

        $this->view->display('shop-cart', $data);
    }
}