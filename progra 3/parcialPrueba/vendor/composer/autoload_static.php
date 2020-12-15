<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit121829bbac3ce92cfc3f4cfc19269a0c
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit121829bbac3ce92cfc3f4cfc19269a0c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit121829bbac3ce92cfc3f4cfc19269a0c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
