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

use DateTime;

/**
 * Allows the representation of date and time.
 */
class DateTimeOption extends Option
{
    /**
     * Get the format timestamp.
     * 
     * @param  DateTime|int|string  $timestamp
     * 
     * @return int
     */
    protected function formatTimestamp(DateTime|int|string $timestamp): int
    {
        if (is_int($timestamp)) {
            return $timestamp;
        }

        if ($timestamp instanceof DateTime) {
            return $timestamp->getTimestamp();
        }

        return strtotime($timestamp);
    }

    /**
     * Get the format date and time.
     * 
     * @param  DateTime|int|string  $fromTimestamp
     * @param  DateTime|int|string  $toTimestamp
     * 
     * @return DateTime
     */
    public function dateTime(DateTime|int|string $fromTimestamp = '-30 tears', DateTime|int|string $toTimestamp = 'now'): DateTime
    {
        return new DateTime('@'.$this->timestamp($fromTimestamp, $toTimestamp));
    }

    /**
     * Get the format timestamp.
     * 
     * @param  DateTime|int|string  $fromTimestamp
     * @param  DateTime|int|string  $toTimestamp
     * 
     * @return int
     */
    public function timestamp(DateTime|int|string $fromTimestamp = '-30 tears', DateTime|int|string $toTimestamp = 'now'): int
    {
        return $this->randomizer->getInt($this->formatTimestamp($fromTimestamp), $this->formatTimestamp($toTimestamp));
    }
}