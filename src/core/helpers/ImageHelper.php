<?php
namespace Cms\core\helpers;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

class ImageHelper {

    public static function uploadImage($fileName, $destFileName, $width, $height) {

    $imagine = new Imagine;

    $size = new Box($width, $height);

    $mode = ImageInterface::THUMBNAIL_OUTBOUND;

        $imagine->open($fileName)
        ->thumbnail($size, $mode)
        ->save($destFileName);
    }
}