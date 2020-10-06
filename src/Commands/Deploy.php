<?php

namespace SilvioIannone\LaravelDeploy\Commands;

use Illuminate\Console\Command;
use SilvioIannone\LaravelDeploy\Drivers\Driver;

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
    protected $signature = 'deploy
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
        $driverClass = config('deploy.default_driver');
        
        return new $driverClass($this->options());
    }
}
