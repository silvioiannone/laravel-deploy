<?php

namespace SilvioIannone\LaravelDeploy\Utils;

use \Illuminate\Support\Arr as IlluminateArr;

/**
 * Array utils.
 */
class Arr extends IlluminateArr
{
    /**
     * Remove all the null values from the given array.
     */
    public static function clean(array $source): array
    {
        return array_filter($source, static fn ($value): bool => $value !== null);
    }
}
