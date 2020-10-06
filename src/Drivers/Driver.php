<?php

namespace SilvioIannone\LaravelDeploy\Drivers;

use Bloom\Cluster\Kernel\Framework\Support\Arr;
use Illuminate\Support\Str;

/**
 * A Laravel-deploy driver.
 */
abstract class Driver
{
    /**
     * Driver configuration.
     */
    protected array $config = [];
    
    /**
     * Constructor.
     */
    public function __construct(array $config)
    {
        $this->initConfig($config);
    }
    
    /**
     * Get the driver name.
     */
    public static function name(): string
    {
        return (new \ReflectionClass(static::class))->getShortName();
    }
    
    /**
     * Initialize the driver configuration.
     */
    protected function initConfig(array $config): void
    {
        $configKey = 'deploy.drivers.' . Str::lower(Str::snake(static::name()));
    
        // Clean up the configurations by removing the null values.
        $cleanUp = static fn (array $config)
            => array_filter($config, static fn ($value): bool => $value !== null);
        
        $this->config = array_merge($cleanUp(config($configKey)), $cleanUp($config));
    }
    
    /**
     * Get a configuration option.
     *
     * @return mixed
     */
    protected function getConfig(string $key)
    {
        return Arr::get($this->config, $key);
    }
    
    /**
     * Run the deployment.
     */
    public function deploy(): void
    {
        $this->trigger();
    }
    
    /**
     * Trigger the deployment.
     */
    abstract protected function trigger(): void;
}
