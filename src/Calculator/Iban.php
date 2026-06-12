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
 * Utility class for validating alphanumeric and MOD97 numbers.
 */
class Iban
{
    /**
     * Generates IBAN Checksum.
     * 
     * @param string $iban
     *
     * @return string
     */
    public static function checksum(string $iban): string
    {
        // Move first four digits to end and set checksum to '00'
        $checkString = substr($iban, 4) . substr($iban, 0, 2) . '00';

        // Replace all letters with their number equivalents
        $checkString = preg_replace_callback(
            '/[A-Z]/',
            static function (array $matches): string {
                return (string) self::alphaToNumber($matches[0]);
            },
            $checkString,
        );

        // Perform mod 97 and subtract from 98
        $checksum = 98 - self::mod97($checkString);

        return str_pad($checksum, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Converts letter to number.
     * 
     * @param string $char
     *
     * @return int
     */
    public static function alphaToNumber(string $char): int
    {
        return ord($char) - 55;
    }

    /**
     * Calculates mod97 on a numeric string.
     *
     * @param string $number
     *
     * @return int
     */
    public static function mod97(string $number): int
    {
        $checksum = (int) $number[0];

        for ($i = 1, $size = strlen($number); $i < $size; ++$i) {
            $checksum = (10 * $checksum + (int) $number[$i]) % 97;
        }

        return $checksum;
    }

    /**
     * Checks whether an IBAN has a valid checksum.
     * 
     * @param string $iban
     *
     * @return bool
     */
    public static function isValid(string $iban): bool
    {
        return self::checksum($iban) === substr($iban, 2, 2);
    }
}