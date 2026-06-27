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
use InvalidArgumentException;

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

    /**
     * @param string $id
     *
     * @throws \Fibber\Exception\NotFoundContainerException
     *
     * @return mixed
     */
    public function ext(string $id)
    {
        if ( ! $this->container->has($id)) {
            throw new Exception\NotFoundContainerException(sprintf(
                'No Fibber extension with id "%s" was loaded.',
                $id,
            ));
        }

        $extension = $this->container->get($id);

        return $extension;
    }

    /**
     * @param string $format
     *
     * @return callable
     */
    public function getFormatter($format)
    {
        if (isset($this->formatters[$format])) {
            return $this->formatters[$format];
        }

        if (method_exists($this, $format)) {
            $this->formatters[$format] = [$this, $format];

            return $this->formatters[$format];
        }

        // "Faker\Core\Barcode->ean13"
        if (preg_match('|^([a-zA-Z0-9\\\]+)->([a-zA-Z0-9]+)$|', $format, $matches)) {
            $this->formatters[$format] = [$this->ext($matches[1]), $matches[2]];

            return $this->formatters[$format];
        }

        foreach ($this->providers as $provider) {
            if (method_exists($provider, $format)) {
                $this->formatters[$format] = [$provider, $format];

                return $this->formatters[$format];
            }
        }

        throw new InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    }

    /**
     * Replaces tokens ('{{ tokenName }}') with the result from the token method call
     *
     * @param string $string String that needs to bet parsed
     *
     * @return string
     */
    public function parse($string)
    {
        $callback = function ($matches) {
            return $this->format($matches[1]);
        };

        return preg_replace_callback('/{{\s?(\w+|[\w\\\]+->\w+?)\s?}}/u', $callback, $string);
    }

    public function format($format, $arguments = [])
    {
        return call_user_func_array($this->getFormatter($format), $arguments);
    }

     /**
     * @param string $attribute
     *
     * @deprecated Use a method instead.
     */
    public function __get($attribute)
    {
        trigger_deprecation('jalexcam/fibber', '1.0', 'Accessing property "%s" is deprecated, use "%s()" instead.', $attribute, $attribute);

        return $this->format($attribute);
    }

    /**
     * @param string $method
     * @param array  $attributes
     */
    public function __call($method, $attributes)
    {
        return $this->format($method, $attributes);
    }

    public function __wakeup()
    {
        $this->formatters = [];
    }
}