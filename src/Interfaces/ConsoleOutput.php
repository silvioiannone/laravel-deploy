<?php

namespace SilvioIannone\LaravelDeploy\Interfaces;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Output interface.
 *
 * This interface should be implemented by a driver that aims to output content to the console while
 * running.
 */
interface ConsoleOutput
{
    /**
     * Set the output channel.
     */
    public function setOutput(OutputInterface $output);
}
