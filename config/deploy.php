<?php

/**
 * Laravel-deploy configuration file.
 */
return [

    /**
     * Global driver specific configuration.
     */
    'drivers' => [

        /**
         * Envoyer driver configuration.
         */
        'envoyer' => [

            /**
             * Laravel envoyer token.
             *
             * Required!
             */
            'token' => '',

            /**
             * The branch that will be used to run the deployment.
             */
            'branch' => 'master'
        ]
    ],

    /**
     * Deployment targets configurations.
     */
    'targets' => [

        /**
         * Define the different targets that will receive a deployment.
         *
         * Here's an example:
         */
        'staging' => [
            'driver' => \SilvioIannone\LaravelDeploy\Drivers\Envoyer::class,
            'config' => [
                /**
                 * Driver specific configuration. The options set will override the defaults set in
                 * the `drivers` section of this configuration file.
                 */
                'token' => '', // Retrieve this from and environment file.
                'branch' => 'next' // Override the default `master` branch.
            ]
        ]
    ]
];
