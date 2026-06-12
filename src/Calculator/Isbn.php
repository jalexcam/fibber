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
 * Utility class for validating ISBN-10.
 */
class Isbn
{
    /**
     * ISBN-10 validation pattern.
     * 
     * @var string 
     */
    public const PATTERN = '/^\d{9}[0-9X]$/';

    /**
     * Get the ISBN-10 check digit.
     *
     * @param string $input ISBN without check-digit
     * 
     * @return string
     *
     * @throws \LengthException When wrong input length passed
     */
    public static function checksum(string $input): string
    {
        $length = 9;

        if (strlen($input) !== $length) {
            throw new \LengthException(sprintf('Input length should be equal to %d', $length));
        }

        $digits = str_split($input);

        array_walk(
            $digits,
            static function (&$digit, $position): void {
                $digit *= (10 - $position)  ;
            },
        );

        $result = (11 - array_sum($digits) % 11) % 11;

        // 10 is replaced by X
        return ($result < 10) ? (string) $result : 'X';
    }

    /**
     * Checks whether the provided number is a valid ISBN-10 number.
     *
     * @param string $isbn  ISBN to check
     * 
     * @return bool
     */
    public static function isValid(string $isbn): bool
    {
        if ( ! preg_match(self::PATTERN, $isbn)) {
            return false;
        }

        return self::checksum(substr($isbn, 0, -1)) === substr($isbn, -1);
    }
}