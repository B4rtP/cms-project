<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateAgainstPattern implements ValidationRuleInterface {

    private $pattern;

    public function __construct($pattern) {
        $this->pattern = $pattern;
    }

    public function run($subject) {

        $noSpaces = str_replace(' ', '', $subject);

        if(!preg_match($this->pattern, $noSpaces)) {
            return 'format is incorrect';
        }
        return true;

    }
}