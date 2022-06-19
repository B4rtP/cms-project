<?php

namespace Cms\admin\models;
use Cms\core\Entity;

class User extends Entity {

    public function __construct($dbc) {
        parent::__construct($dbc, 'users');
    }
}