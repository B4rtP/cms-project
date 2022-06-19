<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateMaxLenght implements ValidationRuleInterface{

    private $maxLenght;

    public function __construct($maxLenght) {
        $this->maxLenght = $maxLenght;
    }

    public function run($subject) {

        if (strlen(trim($subject)) > $this->maxLenght) {
            return 'maximal lenght must be below ' . $this->maxLenght . ' characters';
        }
        return true;
    }
}
