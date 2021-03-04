<?php

namespace SilvioIannone\LaravelDeploy\Drivers;

use Illuminate\Support\Collection;
use SilvioIannone\EnvoyerPhp\Client;
use SilvioIannone\LaravelDeploy\Interfaces\ConsoleOutput as ConsoleOutputInterface;
use SilvioIannone\LaravelDeploy\Traits\ConsoleOutput;

/**
 * Laravel Envoyer driver.
 */
class Envoyer extends Driver implements ConsoleOutputInterface
{
    use ConsoleOutput;

    /**
     * Trigger the deployment.
     */
    protected function trigger(): void
    {
        $envoyer = (new Client($this->getConfig('token')));

        $project = $envoyer->projects()
            ->all()
            ->where('name', $this->getConfig('name'))
            ->first();

        $envoyer->projects()->deploy($project->get('id'));

        // Wait a few seconds for the deployment to be started.
        sleep(3);

        $deployment = $envoyer->projects()
            ->deployments($project->get('id'))->first();
        $deployment = $envoyer->projects()
            ->deployment($project->get('id'), $deployment->get('id'));

        $currentProcess = null;

        $bar = $this->progress($deployment->get('processes')->count());
        $bar->start();

        while ($this->deploymentIsRunning($deployment)) {
            sleep(2);

            $deployment = $envoyer->projects()
                ->deployment($project->get('id'), $deployment->get('id'));

            $currentProcess = $deployment->get('processes')
                ->where('status', 'running')
                ->first();

            $completedProcesses = $deployment->get('processes')
                ->where('status', 'finished')
                ->count();

            if ($completedProcesses) {
                $bar->setProgress($completedProcesses);
            }

            if ($currentProcess) {
                $bar->setMessage('Running step: ' . $currentProcess->get('name'));
            }
        }

        $bar->finish();
    }

    /**
     * Whether the deployment is running or not.
     */
    protected function deploymentIsRunning(Collection $deployment): bool
    {
        // We could use the "status" property set on the deployment but the deployment status is
        // "error" even when the deployment is manually cancelled.
        return ! $this->deploymentIsFailed($deployment) &&
               ! $this->deploymentIsSuccessful($deployment) &&
               ! $this->deploymentIsCancelled($deployment);
    }

    /**
     * Whether the deployment is failed.
     */
    protected function deploymentIsFailed(Collection $deployment): bool
    {
        // The deployment has failed if at least one process has failed.
        return (bool) $deployment->get('processes')
            ->where('status', 'error')
            ->count();
    }

    /**
     * Whether the deployment is cancelled.
     */
    protected function deploymentIsCancelled(Collection $deployment): bool
    {
        return (bool) $deployment->get('processes')
            ->where('status', 'cancelled')
            ->whereNotNull('started_at')
            ->count();
    }

    /**
     * Whether the deployment is successful.
     */
    protected function deploymentIsSuccessful(Collection $deployment): bool
    {
        // The deployment is successful if all the processes are finished.
        $finishedProcessesCount = $deployment->get('processes')
            ->where('status', 'finished')
            ->count();

        return $finishedProcessesCount === $deployment->get('processes')->count();
    }
}
