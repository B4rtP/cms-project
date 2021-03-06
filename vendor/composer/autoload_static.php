<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit38be18c6ca8592644cbf927709344101
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Imagine\\' => 8,
        ),
        'C' => 
        array (
            'Cms\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Imagine\\' => 
        array (
            0 => __DIR__ . '/..' . '/imagine/imagine/src',
        ),
        'Cms\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit38be18c6ca8592644cbf927709344101::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit38be18c6ca8592644cbf927709344101::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit38be18c6ca8592644cbf927709344101::$classMap;

        }, null, ClassLoader::class);
    }
}
