<?php

use Cms\core\Controller;
use Cms\core\View;
use Cms\admin\models\User;
use Cms\models\Page;
use Cms\models\Gallery;
use Cms\shop\models\Order;
use Cms\shop\models\Product;

class DashboardController extends Controller {

    public function beforeAction() {

        if($_SESSION['admin'] ?? 0) {
            return true;
        }
        $this->loginAction();
    }

    public function loginAction() {

        if ($_POST['login-submit'] ?? 0) {

            $username = $_POST['admin-uname'];
            $password = $_POST['admin-pass'];

            $user = new User($this->dbc);
            $userObj = $user->findBy('username', $username);

            if ($userObj->privileges == 'admin' && password_verify($password, $userObj->password)) {
                $_SESSION['admin'] = 1;
                header('Location:/admin');
                die();
            }
            $data['error'] = 'username or password is invalid';
        }
        $view = new View('login');
        $view->display('', $data ?? []);
    }


    public function indexAction() {

        $pages = new Page($this->dbc);
        $data['total_pages'] = $pages->countRows();

        $images = new Gallery($this->dbc);
        $data['total_images'] = $images->countRows();

        $users = new User($this->dbc);
        $data['total_users'] = $users->countRows();

        $products = new Product($this->dbc);
        $data['total_products'] = $products->countRows();

        $orders = new Order($this->dbc);
        $data['total_orders'] = $orders->countRows();

        $this->view->display('dashboard', $data);
    }

    public function logoutAction() {

        unset($_SESSION['admin']);
        header('Location:/');
        die();
    }
}