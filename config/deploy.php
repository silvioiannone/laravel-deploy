<?php

/**
 * Laravel-deploy configuration file.
 */
return [

    /**
     * The default driver that will be executed when running `artisan deploy`.
     */
    'default_driver' => \SilvioIannone\LaravelDeploy\Drivers\SimpleEnvoyer::class,

    /**
     * Driver specific configuration.
     */
    'drivers' => [

        /**
         * Simple Envoyer driver configuration.
         */
        'simple_envoyer' => [

            /**
             * Laravel envoyer token.
             */
            'token' => env('LARAVEL_DEPLOY_ENVOYER_TOKEN'),

            /**
             * The branch that will be used to run the deployment.
             */
            'branch' => env('LARAVEL_DEPLOY_ENVOYER_BRANCH', 'master')
        ],

        /**
         * Envoyer driver configuration.
         */
        'envoyer' => [

            /**
             * Laravel Envoyer API token.
             */
            'token' => env('LARAVEL_ENVOYER_API_TOKEN'),

            /**
             * Laravel Envoyer project name.
             */
            'name' => env('APP_NAME', env('LARAVEL_ENVOYER_PROJECT_NAME'))
        ]
    ],

    /**
     * Deployment targets configurations.
     */
    'targets' => [
        // In here You can define the different deployment targets.
        //
        // Example:
        //
        // 'production' target.
        // 'production' => [
        //
        //     Driver used by the production target.
        //     'driver' => \SilvioIannone\LaravelDeploy\Drivers\Envoyer::class,
        //
        //     Driver configuration. This confiration will override the default value specified in
        //     `deploy.drivers` section just above.
        //     'config' => [
        //         'token' => env('LARAVEL_DEPLOY_ENVOYER_PRODUCTION_TOKEN'),
        //         'name' => 'BloomEstate - Updated',
        //         'branch' => env('LARAVEL_DEPLOY_ENVOYER_PRODUCTION_BRANCH', 'master'),
        //     ]
        // ]
    ]
];
