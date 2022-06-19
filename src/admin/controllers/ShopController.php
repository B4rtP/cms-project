<?php

use Cms\core\Controller;
use Cms\core\Validation;
use Cms\core\helpers\ImageHelper;
use Cms\core\helpers\UploadHelper;
use Cms\core\validationRules\ValidateFileExtension;
use Cms\core\validationRules\ValidateNumber;
use Cms\core\validationRules\ValidateNoEmpty;
use Cms\shop\models\Product;

class ShopController extends Controller {

    //list all products
    public function indexAction() {

        $product = new Product($this->dbc);
        $data['products'] = $product->findAll();

        $this->view->display('list-products', $data);
    }
    

    public function addAction() {

        if($_POST['add-product'] ?? false) {

            $name = $_POST['name'];
            $type = $_POST['type'];
            $description = $_POST['description'];
            $weight = $_POST['weight'];
            $price = $_POST['price'];
            $file = $_FILES['product-img'];
            
            $validator = new Validation();

            $validator
            ->validate($name, 'name', [new ValidateNoEmpty])

            ->validate($price, 'price', [new ValidateNoEmpty, new ValidateNumber])

            ->validate($weight, 'weight', [new ValidateNoEmpty])

            ->validate($file['name'], 'image', [new ValidateNoEmpty])

            ->validate(UploadHelper::getExtension($file['name']), 'extension', [new ValidateFileExtension]);

            if(!$data['errors'] = $validator->getErrors()) {

                $newImgName = $this->imageUploadHandler($file);

                $product = new Product($this->dbc);
                $product->save([
                    'name' => $name,
                    'type' => $type,
                    'description' => $description,
                    'product_weight' => $weight,
                    'price' => $price,
                    'image_name' => $newImgName]);
                header('Location:/admin/?section=shop');
                exit;
            }
        }
        $this->view->display('new-product', $data ?? []);
    }


    public function editAction() {

        $product = new Product($this->dbc);
        $oldProduct = $product->findBy('id', $this->id);

        if($_POST['edit-product'] ?? false) {

            $name = $_POST['new-name'];
            $type = $_POST['new-type'];
            $description = $_POST['new-description'];
            $weight = $_POST['new-weight'];
            $price = $_POST['new-price'];
            $file = $_FILES['new-img'];

            $validator = new Validation();

            $validator
            ->validate($name, 'new-name', [new ValidateNoEmpty])

            ->validate($price, 'new-price', [new ValidateNoEmpty, new ValidateNumber])

            ->validate($weight, 'new-weight', [new ValidateNoEmpty]);

            if($file['name']) {
                $validator->validate(UploadHelper::getExtension($file['name']), 'image-extension', [new ValidateFileExtension]);
            }
            if (!$data['errors'] = $validator->getErrors()) {

                $dbArray = [
                    'name' => $name,
                    'type' => $type,
                    'description' => $description,
                    'product_weight' => $weight,
                    'price' => $price
                ];

                if($file['name']) {

                    $newImgName = $this->imageUploadHandler($file);

                    $dbArray['image_name'] = $newImgName;

                    //delete previous image
                    $oldImg = $oldProduct->image_name;
                    unlink(UPLOADS . $oldImg);
                    unlink(SHOP_IMGS . $oldImg);
                    unlink(SHOP_IMGS . 'thumbnails/' . $oldImg);

                }
                $product->update($dbArray, $this->id);
                header('Location:/admin/?section=shop');
                exit;
            }
        }
        $data['product'] = $oldProduct;
        $this->view->display('edit-product', $data);
    }


    private function imageUploadHandler($file) {

        $newImgName = UploadHelper::getUniqName($file['name']);
        $newImgPath = UploadHelper::moveFile($file['tmp_name'], UPLOADS . $newImgName);

        ImageHelper::uploadImage($newImgPath, SHOP_IMGS . $newImgName, 2400, 2400);
        ImageHelper::uploadImage($newImgPath, SHOP_IMGS . 'thumbnails/' . $newImgName, 500, 500);

        return $newImgName;
    }

    public function deleteAction() {

        $product = new Product($this->dbc);
        $productObj = $product->findBy('id', $this->id);
        $imageName = $productObj->image_name;
        $product->deleteById($this->id);

        unlink(UPLOADS . $imageName);
        unlink(SHOP_IMGS . $imageName);
        unlink(SHOP_IMGS . 'thumbnails/' . $imageName);

        header('Location:/admin/?section=shop');
        exit;
    }
}