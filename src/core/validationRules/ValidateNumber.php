<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateNumber implements ValidationRuleInterface{

    public function run($subject) {

        $noSpaces = str_replace(' ', '', $subject);

        if (!is_numeric($noSpaces)) {
            return 'input must be a number';
        }
        return true;
    }
}