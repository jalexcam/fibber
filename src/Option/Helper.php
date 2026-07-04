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

namespace Fibber\Option;

use Random\Randomizer;

final class Helper
{
    /**
     * Get the radomizer.
     * 
     * @var Randomizer
     */
    protected Randomizer $randomizer;

    /**
     * Constructor. Create a new helper instance.
     * 
     * @param Randomizer $randomizer
     * 
     * @return void
     */
    public function __construct(Randomizer $randomizer)
    {
        $this->randomizer = $randomizer;
    }
}