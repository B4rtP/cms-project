<?php

namespace Cms\shop\models;

use Cms\core\Entity;

class ShippingProvider extends Entity {

    public function __construct($dbc) {
        parent::__construct($dbc, 'shipping_providers');
    }
}