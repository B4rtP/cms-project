<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateNoEmpty implements ValidationRuleInterface{

    public function run($subject) {
        if(empty(trim($subject))) {
            return 'field can not be empty';
        }
        return true;
    }
}