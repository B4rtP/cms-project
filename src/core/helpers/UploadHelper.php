<?php

namespace Cms\core\helpers;

class UploadHelper {

    public static function getUniqName($fileName) {

        $extension = self::getExtension($fileName);
        return uniqid('', false) . '.' . $extension;
    }

    public static function getExtension($fileName) {
        $lwrCaseName = strtolower($fileName);
        $array = explode('.', $lwrCaseName);
        $extension = end($array);
        return $extension;
    }

    public static function moveFile($from, $to) {
        move_uploaded_file($from, $to);
        return $to;
    }
}