<?php

namespace Cms\core\traits;

use Cms\core\Validation;
use Cms\core\validationRules\OnlyLetters;
use Cms\core\validationRules\ValidateEmail;
use Cms\core\validationRules\ValidateMinNumberLenght;
use Cms\core\validationRules\ValidateNoEmpty;
use Cms\core\validationRules\ValidateNumber;

trait ReusableValidationTrait {

    public function validateCommonFields(
        Validation $validator, $fName, $lName, $email, $phone,$address,$postCode,$country
    ) {

        $validator
        ->validate($fName, 'fname', [new ValidateNoEmpty, new OnlyLetters])
        ->validate($lName, 'lname', [new ValidateNoEmpty, new OnlyLetters])
        ->validate($email, 'email', [new ValidateNoEmpty, new ValidateEmail])
        ->validate($phone, 'phone', [new ValidateNoEmpty, new ValidateMinNumberLenght(12)])
        ->validate($address, 'address', [new ValidateNoEmpty, new ValidateMinNumberLenght(1)])
        ->validate($postCode, 'pcode', [new ValidateNumber, new ValidateMinNumberLenght(5)])
        ->validate($country, 'country', [new ValidateNoEmpty, new OnlyLetters]);
    }
}
