<?php

namespace Cms\shop\models;

use Cms\core\Entity;

class Order extends Entity {

    public function __construct($dbc) {
        parent::__construct($dbc, 'orders');
    }
}