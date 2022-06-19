<?php

use Cms\core\Controller;
use Cms\core\helpers\ImageHelper;
use Cms\core\helpers\UploadHelper;
use Cms\core\Validation;
use Cms\core\validationRules\ValidateFileExtension;
use Cms\core\validationRules\ValidateNoEmpty;
use Cms\models\Gallery;

class GalleryController extends Controller {

    public function indexAction() {

        $gallery = new Gallery($this->dbc);
        $data['images'] = $gallery->findAll();

        $this->view->display('list-images', $data);
    }

    public function statusAction() {

        $gallery = new Gallery($this->dbc);

        if($_GET['deactivate'] ?? false) {
            $gallery->update(['status' => 0], $this->id);
        }
        if($_GET['activate'] ?? false) {
            $gallery->update(['status' => 1], $this->id);
        }
        header('Location:/admin/?section=gallery');
        exit;
    }

    public function titleAction() {
        if($_POST['set-new-title'] ?? 0) {

            $newTitle = $_POST['new-title'];
    
            $gallery = new Gallery($this->dbc);
            $gallery->update(['image_title' => $newTitle], $this->id);
        }
        header('Location:/admin/?section=gallery');
        exit;
    }

    public function uploadAction() {
        
        $gallery = new Gallery($this->dbc);

        if($_POST['upload'] ?? false) {

            $title = $_POST['image_title'];
            $file = $_FILES['image'];

            $validator = new Validation();

            $validator
            ->validate($file['name'], 'image', [new ValidateNoEmpty])
            ->validate(UploadHelper::getExtension($file['name']), 'image-extension', [new ValidateFileExtension]);

            if(!$data['errors'] = $validator->getErrors()) {

                $newImgName = UploadHelper::getUniqName($file['name']);
                $newImgPath = UploadHelper::moveFile($file['tmp_name'], UPLOADS . $newImgName);

                ImageHelper::uploadImage($newImgPath, GALLERY_IMGS . $newImgName, 1200, 1800);
                ImageHelper::uploadImage($newImgPath, GALLERY_IMGS . 'thumbnails/' . $newImgName, 600, 900);

                $gallery->save([
                    'file_name' => $newImgName,
                    'image_title' => $title,
                    'status' => 1
                ]);
            }
        }
        $data['images'] = $gallery->findAll();
        $this->view->display('list-images', $data);
    }

    public function deleteAction() {

        // Delete DB record
        $gallery = new Gallery($this->dbc);
        $galleryObj = $gallery->findBy('id', $this->id);
        $fileName = $galleryObj->file_name;
        $gallery->deleteById($this->id);

        // Delete actual file(s)
        unlink(UPLOADS. $fileName);
        unlink(GALLERY_IMGS. $fileName);
        unlink(GALLERY_IMGS.'thumbnails/'. $fileName);

        header('Location:/admin/?section=gallery');
        exit;
    }
}