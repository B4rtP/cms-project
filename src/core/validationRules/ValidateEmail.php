<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateEmail implements ValidationRuleInterface{

    public function run($subject) {
        if(!empty($subject)) {
            $result = filter_var($subject, FILTER_VALIDATE_EMAIL);
            if(!$result) {
                return 'email is not valid';
            }
            return true;
        }
    }
}