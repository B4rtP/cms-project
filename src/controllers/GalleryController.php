<?php

use Cms\core\Controller;
use Cms\models\Page;
use Cms\models\Gallery;

class GalleryController extends Controller {

    public function indexAction() {

        $page = new Page($this->dbc);
        $data['page'] = $page->findBy('id', $this->entityId);

        $gallery = new Gallery($this->dbc);
        $data['images'] = $gallery->findAll();
        
        $this->view->display('gallery-all', $data);
    }

    public function imageAction() {

        $imageId = array_shift($this->urlParams);

        $gallery = new Gallery($this->dbc);
        $data['image'] = $gallery->findBy('id', $imageId);

        $this->view->display('gallery-single', $data);
    }
}