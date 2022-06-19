<?php

namespace Cms\models;
use Cms\core\Entity;

class Router extends Entity {

    public function __construct($dbc) {
        parent::__construct($dbc, 'routes');
    }
}