<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateMinSpecialCharLenght implements ValidationRuleInterface{

    private $lenght;

    public function __construct($lenght) {
        $this->lenght = $lenght;
    }

    public function run($subject) {

        $regex = '/[*@!?#%&(){}^$\/\\+-]{'.$this->lenght.',}/';

        $noSpaces = str_replace(' ', '', $subject);

        if(!preg_match($regex, $noSpaces)) {
            return 'field must contain at least '. $this->lenght.
            ' of following characters: *@!?#%&(){}^$/\+-';
        }
        return true;
    }
}