<?php

namespace SilvioIannone\LaravelDeploy\Traits;

use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A trait that can be used by drivers that want to output to the console.
 */
trait ConsoleOutput
{
    /**
     * The output channel.
     */
    protected ?OutputStyle $outputStyle = null;
    
    /**
     * Set the output channel.
     */
    public function setOutput(OutputInterface $output): void
    {
        $this->outputStyle = $output;
    }
    
    /**
     * Access the output channel.
     */
    protected function output(): OutputStyle
    {
        if (! $this->outputStyle) {
            throw new \RuntimeException('The output is not set.');
        }
        
        return $this->outputStyle;
    }
    
    /**
     * Make a progress bar.
     */
    protected function progress(int $max = 0): ProgressBar
    {
        $bar = $this->output()->createProgressBar($max);
        
        $bar->setFormat(" %current%/%max% [%bar%] %percent:3s%%\n  %message%");
        $bar->setMessage('');
        
        return $bar;
    }
}
