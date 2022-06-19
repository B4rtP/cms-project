<?php

namespace Cms\core;

use Cms\models\User;
use Cms\core\Database;

class Authentication {

    public function verifyBy($column, $value, $password) {

        if($userObj = $this->recordExists($column, $value)) {

            $passwdHash = $userObj->password;

            if(password_verify($password, $passwdHash)) {
                return $userObj;
            }
        }
        return false;
    }

    public function recordExists($column, $value) {

        $db = Database::getInstance();
        $dbc = $db->getConnection();

        $user = new User($dbc);
        
        if(!empty($value)) {
            $userObj = $user->findBy($column, $value);

            if ($userObj != false) {
                return $userObj;
            }
            return false;
        }
    }
}