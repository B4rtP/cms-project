<?php

namespace Cms\core\helpers;

class SessionHelper {

    public static function unsetByValue($value, $sessionKey) {

        $itemKey = array_search($value, $_SESSION[$sessionKey]);
        unset($_SESSION[$sessionKey][$itemKey]);
    }

    public static function unsetAllByValue($value, $sessionKey) {

        foreach ($_SESSION[$sessionKey] as $sessionValue) {
            if ($sessionValue == $value) {
                $key = array_search($sessionValue, $_SESSION[$sessionKey]);
                unset($_SESSION[$sessionKey][$key]);
            }
        }
    }

    public static function unsetByKeysIfExist(array $sessionKeys) {
        foreach ($sessionKeys as $sessionKey) {
            if(array_key_exists($sessionKey, $_SESSION)) {
                unset($_SESSION[$sessionKey]);
            }
        }
    }

    public static function containsValue($sessionKey) {
        if(empty($_SESSION[$sessionKey]) || is_null($_SESSION[$sessionKey])) {
            return false;
        }
        return true;
    }

    public static function addValue($value, $sessionKey) {
        if(isset($_SESSION[$sessionKey])) {
            array_push($_SESSION[$sessionKey], $value);
        }
    }

    public static function createArray($sessionKey) {
        if(!isset($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey] = [];
        }
    }

    public static function count($sessionKey) {
        if (isset($_SESSION[$sessionKey])) {
            $result = count($_SESSION[$sessionKey]);
            return $result;
        }
    }

    public static function countUniqueValues($sessionKey) {
        $result = array_count_values($_SESSION[$sessionKey]);
        return $result;
    }

    public static function getUniqueValues($sessionKey) {
        $result = array_unique($_SESSION[$sessionKey]);
        return $result;
    }

    public static function createOrOverwrite($sessionKey, $sessionValue) {
            $_SESSION[$sessionKey] = $sessionValue;
    }
}