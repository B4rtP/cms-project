<?php

use Cms\core\Controller;
use Cms\models\Page;

class PagesController extends Controller {

    public function indexAction() {

        $page = new Page($this->dbc);
        $data['pages'] = $page->findAll();

        $this->view->display('list-pages', $data);
    }

    public function editAction() {

        if($_POST['submit'] ?? 0) {
            $page = new Page($this->dbc);
            $page->update($_POST, $this->id);
            
            header('Location:/admin?section=pages');
        }

        $page = new Page($this->dbc);
        $data['page'] = $page->findBy('id', $this->id);

        $this->view->display('edit-page', $data);
        
    }
}