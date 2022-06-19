<?php

namespace Cms\core\validationRules;

use Cms\core\interfaces\ValidationRuleInterface;

class ValidateFileExtension implements ValidationRuleInterface{

    private $allowedExtensions = ['jpg', 'png'];

    public function run($subject) {
        if(!empty($subject)) {
            if (!in_array($subject, $this->allowedExtensions)){
                return 'allowed extensions are: '.implode(', ', $this->allowedExtensions);
            }
        }
        return true;
    }
}
