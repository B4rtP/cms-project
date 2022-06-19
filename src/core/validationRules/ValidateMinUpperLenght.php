<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateMinUpperLenght implements ValidationRuleInterface{

    private $lenght;

    public function __construct($lenght) {
        $this->lenght = $lenght;
    }

    public function run($subject) {

        $regex = '/[A-Z]{'.$this->lenght.',}/';

        $errorMess = $this->lenght == 1 ? $this->lenght. ' upper-case character' :
        $this->lenght. 'upper-case charaters';

        if(!preg_match($regex, $subject)) {
            return 'field must contain at least '. $errorMess;
        }
        return true;
    }

}