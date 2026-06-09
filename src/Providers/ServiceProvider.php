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

namespace Jalexcam\Fibber\Providers;

use Jalexcam\Fibber\Container\Container;

/**
 * Allows call the service providers of the package.
 */
class ServiceProvider
{
    /**
     * Bootstrap any package services.
     * 
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the package's custom Fibber options.
     *
     * @param  array  $options
     *
     * @return void
     */
    public function register(array $options): void
    {
        Container::starting(function (Container $container) use ($options) {
            $container->resolveOptions($options);
        });
    }

}