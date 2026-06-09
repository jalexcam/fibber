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

namespace Jalexcam\Fibber;

use Jalexcam\Fibber\Container\Container;

/**
 * @mixin Container
 */
class Fibber
{
    /**
     * The current locale format (BCP 47 Code).
     *
     * @var string|null
     */
    protected string|null $locale;

    /**
     * Constructor. Create a new Fibber instance.
     * 
     * @param  string|null  $locale
     * 
     * @return void
     */
    public function __construct(string|null $locale = null)
    {
        $this->locale = $locale;
    }

    /**
     * Magic method.
     * 
     * Dynamically call the option with locale.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        // We simply redirect calls to container to create a new container for each fibber call
        return (new Container())->locale($this->locale)->{$method}(...$parameters);
    }
}