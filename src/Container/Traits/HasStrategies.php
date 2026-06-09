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

namespace Jalexcam\Fibber\Container\Traits;

use Jalexcam\Fibber\Strategies\UniqueStrategy;

/**
 * Trait HasStrategies.
 */
trait HasStrategies
{
    /**
     * The current instance strategies.
     *
     * @var array
     */
    protected array $strategies = [];

    /**
     * Add a unique strategy.
     *
     * @param string $seed
     *
     * @return static
     */
    public function unique(string $seed = ''): static
    {
        $this->strategies[] = UniqueStrategy::forSeed($seed);

        return $this;
    }

    /**
     * Determine if a generated value passes the strategies.
     *
     * @param  mixed  $generatedValue
     *
     * @return bool
     */
    public function passStrategies($generatedValue): bool
    {
        foreach ($this->strategies as $strategy) {
            if ( ! $strategy->pass($generatedValue)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Reset the registered strategies.
     *
     * @return void
     */
    public function eraseStrategies(): void
    {
        $this->strategies = [];
    }

    /**
     * Returns the current strategies for the container.
     *
     * @return array
     */
    public function getStrategies(): array
    {
        return $this->strategies;
    }
}