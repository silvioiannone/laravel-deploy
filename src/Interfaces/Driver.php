<?php

namespace SilvioIannone\LaravelDeploy\Interfaces;

/**
 * Driver interface.
 */
interface Driver
{
    /**
     * Get the driver name.
     */
    public static function name(): string;
    
    /**
     * Run the deployment.
     */
    public function deploy(): void;
}
