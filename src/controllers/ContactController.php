<?php

use Cms\core\Controller;
use Cms\core\Validation;
use Cms\core\validationRules\ValidateMaxLenght;
use Cms\core\validationRules\ValidateMinLenght;
use Cms\core\validationRules\ValidateNoEmpty;
use Cms\models\Page;

class ContactController extends Controller {

    public function beforeAction() {
        if($_SESSION['contact_form_submission'] ?? 0) {

            $page = new Page($this->dbc);
            $data['page'] = $page->findBy('id', 5);

            $this->view->display('basic', $data);

            return false;
        }
        return true;
    }

    public function indexAction() {
        $page = new Page($this->dbc);
        
        if($_POST['submit-contact'] ?? false) {

            $data['errors'] = $this->submitForm($page);
        }
        $data['page'] = $page->findBy('id', $this->entityId);
        $this->view->display('contact-form', $data);
    }

    private function submitForm($page) {

        $title = $_POST['title'];
        $content = $_POST['content'];

        $validator = new Validation();
        
        $validator
        ->validate($title, 'title', [
        new ValidateNoEmpty(),
        new ValidateMinLenght(5),
        new ValidateMaxLenght(50)])

        ->validate($content, 'content', [
        new ValidateNoEmpty(),
        new ValidateMinLenght(10)
        ]);

        if($errors = $validator->getErrors()) {
            return $errors;
        }
        $_SESSION['contact_form_submission'] = 1;
        
        $data['page'] = $page->findBy('id', 4);
        $this->view->display('basic', $data);
        exit;
    }
}