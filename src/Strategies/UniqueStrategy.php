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

namespace Jalexcam\Fibber\Strategies;

use Jalexcam\Fibber\Seeds\HasSeeds;

/**
 * Allows generate a unique value specific.
 */
class UniqueStrategy extends Strategy
{
    use HasSeeds;

    /**
     * The element already tried.
     *
     * @var array
     */
    protected array $tried = [];

    /**
     * Handle the given strategy.
     *
     * @param  mixed  $generatedValue
     *
     * @return bool
     */
    public function pass($generatedValue): bool
    {
        if (in_array($generatedValue, $this->tried, true)) {
            return false;
        }

        $this->tried[] = $generatedValue;

        return true;
    }
}