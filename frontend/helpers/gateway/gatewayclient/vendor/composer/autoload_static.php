<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit477b302f1f44aab56d7f4989638a4357
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'GatewayClient\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'GatewayClient\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/gatewayclient',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit477b302f1f44aab56d7f4989638a4357::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit477b302f1f44aab56d7f4989638a4357::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
