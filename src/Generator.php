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

namespace Fibber;

use Fibber\Container\ContainerInterface;

/**
 * Allows generate the different types of options exists.
 */
class Generator
{
    /**
     * The implementation container.
     * 
     * @var \Fibber\Container\Container
     */
    protected $container;

    /**
     * Get the formatters.
     * 
     * @var array
     */
    protected $formatters = [];
    
    /**
     * Get the providers.
     * 
     * @var array
     */
    protected $providers = [];

    /**
     * Constructor. Create a new Generator instance.
     * 
     * @param ContainerInterface|null $container
     * 
     * @return void
     */
    public function __construct(?ContainerInterface $container = null)
    {
        $this->container = $container ?: Container\ContainerFactory::withDefaultOptions()->build();
    }

    /**
     * Adds the providers.
     * 
     * @param array $provider
     * 
     * @return mixed
     */
    public function addProvider($provider)
    {
        array_unshift($this->providers, $provider);

        $this->formatters = [];
    }

    /**
     * Get all the providers.
     * 
     * @return array
     */
    public function getProviders(): array
    {
        return $this->providers;
    }
}