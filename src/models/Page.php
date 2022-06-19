<?php
namespace Cms\models;
use Cms\core\Entity;

class Page extends Entity {
    public function __construct($dbc) {
        parent::__construct($dbc, 'pages');
    }
}