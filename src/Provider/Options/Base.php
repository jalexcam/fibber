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

namespace Fibber\Provider\Options;

use Fibber\Generator;

/**
 * Allows generate a random of element from the given an array.
 */
class Base
{
    /**
     * Get the generator.
     * 
     * @var Generator
     */
    protected Generator $generator;

    /**
     * Constructor. Create a new Base instance.
     * 
     * @param  Generator  $generator
     * @return void
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }
}