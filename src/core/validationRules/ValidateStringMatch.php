<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateStringMatch implements ValidationRuleInterface{

    private $comparator;

    public function __construct($comparator) {
        $this->comparator = $comparator;
    }

    public function run($subject) {
        if($subject !== $this->comparator) {
            return 'fields are not matching';
        }
        return true;
    }
}