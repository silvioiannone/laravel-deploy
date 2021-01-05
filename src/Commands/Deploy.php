<?php

namespace SilvioIannone\LaravelDeploy\Commands;

use Illuminate\Console\Command;
use SilvioIannone\LaravelDeploy\Drivers\Driver;
use SilvioIannone\LaravelDeploy\Utils\Arr;

/**
 * An Artisan command that deploys the code.
 */
class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy {target : The target that will receive the deployment.}
                                   {--b|branch= : The branch that you want to deploy.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the code.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $driver = $this->makeDriver();

        $this->info('Starting ' . $driver::name() . ' deployment...');

        try {
            $driver->deploy();
        } catch (\Exception $exception) {
            $this->output->error('Something went wrong while deploying. Details:');
            throw $exception;
        }

        $this->output->success('Deployment completed.');
    }

    /**
     * Make a deployment driver instance.
     */
    protected function makeDriver(): Driver
    {
        $target = config('deploy.targets.' . $this->argument('target'));

        $driverClass = $target['driver'];

        return new $driverClass(array_merge($target['config'], Arr::clean($this->options())));
    }
}
