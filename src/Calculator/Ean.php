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

namespace Fibber\Calculator;

/**
 * Utility class for validating EAN-8 and EAN-13 numbers.
 */
class Ean
{
    /**
     * EAN validation pattern.
     * 
     * @var string 
     */
    public const PATTERN = '/^(?:\d{8}|\d{13})$/';

    /**
     * Gets the checksum of an EAN number.
     * 
     * @param  string  $digits
     *
     * @return int
     */
    public static function checksum(string $digits): int
    {
        $sequence = (strlen($digits) + 1) === 8 ? [3, 1] : [1, 3];
        $sums = 0;

        foreach (str_split($digits) as $n => $digit) {
            $sums += ((int) $digit) * $sequence[$n % 2];
        }

        return (10 - $sums % 10) % 10;
    }

    /**
     * Checks whether the provided number is an EAN compliant number and that
     * the checksum is correct.
     *
     * @param  string  $ean 
     *
     * @return bool
     */
    public static function isValid(string $ean): bool
    {
        if ( ! preg_match(self::PATTERN, $ean)) {
            return false;
        }

        return self::checksum(substr($ean, 0, -1)) === (int) substr($ean, -1);
    }
}