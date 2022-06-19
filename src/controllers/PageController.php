<?php

use Cms\core\Controller;
use Cms\models\Page;

class PageController extends Controller {

    public function indexAction() {

        $page = new Page($this->dbc);
        $data['page'] = $page->findBy('id', $this->entityId);

        $this->view->display('basic', $data);
    }
}