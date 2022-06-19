<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateMinLenght implements ValidationRuleInterface {

    private $minLenght;

    public function __construct($minLenght) {
        $this->minLenght = $minLenght;
    }

    public function run($subject) {

        if (strlen(trim($subject)) < $this->minLenght) {
            return 'minimal lenght must be over '. $this->minLenght .' characters';
        }
        return true;
    }
}