<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class OnlyLettersAndNumbers implements ValidationRuleInterface {

    public function run($subject) {

        $regex = '/^[a-zA-ZÀ-ž0-9 ]+$/';

        if (!preg_match($regex, $subject)) {
            return 'field can only contain letters a-z, A-Z, À-ž and numbers';
        }
        return true;
    }
    
}