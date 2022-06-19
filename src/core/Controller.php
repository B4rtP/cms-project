<?php

namespace Cms\core;

class Controller {

    public $urlParams;
    public $entityId;
    public $dbc;
    public $view;

    public function runAction($action) {

        if (method_exists($this, 'beforeAction')) {
            $continue = $this->beforeAction();
            if (!$continue) {
                return;
            }
        }
        $action .= 'Action';
        method_exists($this, $action) ? $this->$action() : die('method/ '.$action.' /does not exists');
    }
}