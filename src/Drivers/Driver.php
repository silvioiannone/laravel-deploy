<?php

namespace SilvioIannone\LaravelDeploy\Drivers;

use Illuminate\Support\Str;
use SilvioIannone\LaravelDeploy\Utils\Arr;

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

        $this->config = array_merge(
            Arr::clean(config($configKey)),
            Arr::clean($config)
        );
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
