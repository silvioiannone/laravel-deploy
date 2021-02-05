<?php

namespace SilvioIannone\LaravelDeploy\Drivers;

use GuzzleHttp\Client;

/**
 * A simple Laravel Envoyer deployment driver that only makes use of the deployment hook.
 */
class SimpleEnvoyer extends Driver
{
    /**
     * Envoyer endpoint.
     */
    protected static string $endpoint = 'https://envoyer.io';

    /**
     * Trigger the deployment.
     */
    protected function trigger(): void
    {
        $token = $this->getConfig('token');

        $query = [
            'branch' => $this->getConfig('branch')
        ];

        (new Client(['base_uri' => static::$endpoint]))
            ->get('/deploy/' . $token, [
                'query' => $query
            ]);
    }
}
