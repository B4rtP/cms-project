<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateMinNumberLenght implements ValidationRuleInterface {

    private $lenght;

    public function __construct($lenght) {
        $this->lenght = $lenght;
    }

    public function run($subject) {

        $whitespaceGone = str_replace(' ', '', $subject);
        
        $errorMess = $this->lenght == 1 ? $this->lenght.' digit' : $this->lenght. ' digits';

        if(!preg_match('/[\d]{'.$this->lenght.',}/', $whitespaceGone)) {
            return 'field must contain at least '. $errorMess;
        }
        return true;
    }
}