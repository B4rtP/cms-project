<?php

namespace Cms\core;

class View {

    public $template;

    public function __construct($template) {
        $this->template = $template;
    }

    public function display($layout, array $dataArray = []) {
        extract($dataArray);
        require VIEW_ROOT. 'templates/'. $this->template. '.html';
    }
}