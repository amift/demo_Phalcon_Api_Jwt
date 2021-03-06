<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit82442908ee5c2dbd79bfae21308cdd35
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

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit82442908ee5c2dbd79bfae21308cdd35::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit82442908ee5c2dbd79bfae21308cdd35::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit82442908ee5c2dbd79bfae21308cdd35::$classMap;

        }, null, ClassLoader::class);
    }
}
