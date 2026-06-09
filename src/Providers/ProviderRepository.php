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

/**
 * Allows load the service providers.
 */
class ProviderRepository
{
    /**
     * Register the application service providers.
     *
     * @param array $providers
     *
     * @return void
     */
    public function load(array $providers): void
    {
        foreach ($providers as $provider) {
            $instance = $this->createProvider($provider);

            $instance->boot();
        }
    }

    /**
     * Create a new provider instance.
     *
     * @param string $provider
     *
     * @return \Jalexcam\Fibber\Providers\ServiceProvider
     */
    public function createProvider($provider): ServiceProvider
    {
        if (is_object($provider)) {
            return $provider;
        }

        return new $provider();
    }
}