<?php

use Cms\core\Controller;
use Cms\core\helpers\SessionHelper;
use Cms\core\Searcher;
use Cms\models\Page;
use Cms\shop\models\Product;

class ShopController extends Controller {

    public function indexAction() {

        $page = new Page($this->dbc);
        $product = new Product($this->dbc);

        $data['message'] = SessionHelper::containsValue('user') ?
        'Welcome ' . $_SESSION['user'] : null;
        
        if ($_POST['search-btn'] ?? false) {

            $searchResult = $this->searchProducts($_POST['search']);
            $searchResult == false ? $data['message'] = 'searched products not found' : null;
        }

        $data['products'] = $searchResult ?? false ?  $searchResult : $product->findAll();
        
        $data['page'] = $page->findBy('id', $this->entityId);

        $this->view->display('shop-main', $data);
    }

    private function searchProducts($input) {

        $searcher = new Searcher($this->dbc, 'products', $input);
        $match = $searcher->inputMatch();
        return $match;
    }
}