<?php

namespace Cms\core\interfaces;

interface ValidationRuleInterface {

    public function run($subject);
}