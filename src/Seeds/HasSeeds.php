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
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@Lenevor.com so we can send you a copy immediately.
 *
 * @package     Fibber
 * @link        https://fibberpackage.com
 * @copyright   Copyright (c) 2026 Alexander Campo <jalexcam@gmail.com>
 * @license     https://opensource.org/licenses/BSD-3-Clause New BSD license or see https://fibberpackage.com/license
 */

namespace Jalexcam\Fibber\Seeds;

/**
 * Trait Hasseds.
 */
trait HasSeeds
{
    protected static array $seeds = [];

    /**
     * Get or create an instance for the given seed.
     *
     * @param  string  $seed
     * @param  array  ...$parameters
     *
     * @return static
     */
    public static function forSeed(string $seed, ...$parameters): static
    {
        return static::$seeds[$seed] ??= new static(...$parameters);
    }

    /**
     * Erase all the registered seeds.
     *
     * @return void
     */
    public function eraseSeeds(): void
    {
        static::$seeds = [];
    }
}