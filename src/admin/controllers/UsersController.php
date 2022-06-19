<?php

use Cms\core\Controller;
use Cms\models\User;

class UsersController extends Controller {

    public function indexAction() {

        $user = new User($this->dbc);
        $data['users'] = $user->findAll();

        $this->view->display('list-users', $data);
    }

    public function inspectAction() {

        $user = new User($this->dbc);
        $data['user'] = $user->findBy('id', $this->id);

        $this->view->display('inspect-user', $data);
    }
}