<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Package Enabled
    |--------------------------------------------------------------------------
    |
    | This value determines whether the package is enabled. By default, it
    | will be enabled if APP_DEBUG is true.
    |
    */

    'enabled' => env('APP_DEBUG'),

    /*
    |--------------------------------------------------------------------------
    | Whitelisted IP Addresses
    |--------------------------------------------------------------------------
    |
    | This value contains a list of IP addresses that are allowed to access
    | the SmartyTerminal.
    |
    */

    'whitelists' => [],

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | This value sets the route information such as the prefix and middleware.
    |
    */

    'route' => [
        'prefix' => config('smartycms_config.route_prefix') . '/terminal',
        'as'     => 'terminal.',

        // If you need auth, you need to use 'web' and specify an 'auth' middleware
        'middleware' => [
            'web',
            SmartyStudio\SmartyCms\Http\Middleware\AuthenticateAdmin::class,
            'role:superadministrator',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enabled Commands
    |--------------------------------------------------------------------------
    |
    | This value contains a list of class names for the available commands
    | for SmartyTerminal.
    |
    */

    'commands' => [
        SmartyStudio\SmartyTerminal\Console\Commands\Artisan::class,
        SmartyStudio\SmartyTerminal\Console\Commands\ArtisanTinker::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Cleanup::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Composer::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Find::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Mysql::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Tail::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Vi::class,
    ],
];
