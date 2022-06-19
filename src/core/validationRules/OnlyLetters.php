<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class OnlyLetters implements ValidationRuleInterface {

    public function run($subject) {

        $regex = '/^[a-zA-ZÀ-ž ]+$/';

        if(!preg_match($regex, $subject)) {
            return 'field can only contain letters a-z, A-Z or À-ž';
        }
        return true;
    }
}