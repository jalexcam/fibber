<?php

/**
 * Fibber Package
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file license.md.
 * It is also available through the world-wide-web at this URL:
 * https://fibberpackage.com/license
 *
 * @package     Fibber
 * @link        https://fibberpackage.com
 * @copyright   Copyright (c) 2026 Alexander Campo <jalexcam@gmail.com>
 * @license     https://opensource.org/licenses/BSD-3-Clause New BSD license or see https://fibberpackage.com/license
 */

namespace Jalexcam\Fibber\Options;

/**
 * Allows return the numbers integer and decimal.
 */
class NumbersOption extends Option
{
    /**
     * Get the digit.
     * 
     * @return int
     */
    public function digit(): int
    {
        return $this->number(0, 9);
    }

    /**
     * Get the number to given a random.
     * 
     * @param  int  $min
     * @param  int  $max
     * 
     * @return int
     */
    public function number(int $min, int $max): int
    {
        return $this->randomizer->getInt($min, $max);
    }

    /**
     * Get the float.
     * 
     * @param  float  $min
     * @param  float  $max
     * 
     * @return float
     */
    public function float(float $min, float $max, int $decimals = 1): float
    {
        if ($min === $max) {
            return (float) number_format($min, $decimals, '.', '');
        }

        $factor = pow(10, $decimals);
        $randomInt = $this->number((int) floor($min * $factor), (int) ceil($max * $factor));

        return (float) number_format($randomInt / $factor, $decimals, '.', '');
    }
}