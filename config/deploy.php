<?php

/**
 * Laravel-deploy configuration file.
 */
return [
    
    /**
     * The default driver that will be executed when running `artisan deploy`.
     */
    'default_driver' => \SilvioIannone\LaravelDeploy\Drivers\Envoyer::class,
    
    /**
     * Driver specific configuration.
     */
    'drivers' => [
    
        /**
         * Envoyer driver configuration.
         */
        'envoyer' => [
    
            /**
             * Laravel envoyer token.
             */
            'token' => env('LARAVEL_DEPLOY_ENVOYER_TOKEN'),
    
            /**
             * The branch that will be used to run the deployment.
             */
            'branch' => env('LARAVEL_DEPLOY_ENVOYER_BRANCH', 'master')
        ]
    ]
];
