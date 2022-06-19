<?php

namespace Cms\core;

class Validation {

    private $subject;
    private $errors;

    public function validate($subject, $errorArrayKey, array $rules) {

        $this->subject = $subject;
        $this->errors[$errorArrayKey] = '';

        foreach ($rules as $rule) {
            $result = $rule->run($this->subject);
            if($result !== true) {
                $this->addError($errorArrayKey, $result);
            }
        }
        return $this;
    }

    private function addError($arrayKey, $reason) {
        $this->errors[$arrayKey] .= $reason . '<br>';
    }

    public function getErrors() {
        if(empty(array_filter($this->errors))) {
            return false;
        }
        return $this->errors;
    }
}