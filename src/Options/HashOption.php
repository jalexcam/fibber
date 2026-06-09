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
 * Allows encrypt a string depending the hash value.
 */
class HashOption extends Option
{
    /**
     * Generate a hash value.
     * 
     * @param  string  $algo
     * 
     * @return string
     */
    protected function hash(string $algo): string
    {
        return hash($algo, $this->randomizer->getBytes(16));
    }

    /**
     * Generate a md5 hash value.
     * 
     * @return string
     */
    public function md5(): string
    {
        return $this->hash('md5');
    }

    /**
     * Generate a sha1 hash value.
     * 
     * @return string
     */
    public function sha1(): string
    {
        return $this->hash('sha1');
    }

    /**
     * Generate a sha256 hash value.
     * 
     * @return string
     */
    public function sha256(): string
    {
        return $this->hash('sha256');
    }

    /**
     * Generate a sha512 hash value.
     * 
     * @return string
     */
    public function sha512(): string
    {
        return $this->hash('sha512');
    }
}