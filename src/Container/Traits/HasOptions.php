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

use BadMethodCallException;
use Random\Randomizer;
use ReflectionClass;
use Jalexcam\Fibber\Container\Container;
use Jalexcam\Fibber\Exceptions\NoOptionLocaleFoundException;
use Jalexcam\Fibber\Options\Option;
use Jalexcam\Options\Traits\HasLocale;
use Jalexcam\Fibber\Container\Enum\Locales;

/**
 * Trait HasOptions.
 */
trait HasOptions
{
    /**
     * The fibber options.
     *
     * @var array
     */
    protected static array $options = [];

    /**
     * The options methods linked to extension name.
     *
     * @var array
     */
    protected static array $optionMethods = [];

    /**
     * Resolve an array of options through the container.
     *
     * @param  array  $options
     *
     * @return static
     */
    public function resolveOptions(array $options): static
    {
        foreach ($options as $option) {
            $this->resolve($option);
        }

        return $this;
    }

    /**
     * Add an option, resolving through the application.
     *
     * @param  Option|string  $option
     *
     * @return Container
     */
    protected function resolve(Option|string $option): Container
    {
        $instance = $option instanceof Option ? $option : new $option(new Randomizer());

        // If the extension supports locale variations
        if (in_array(
            HasLocale::class,
            array_keys((new ReflectionClass($instance::class))->getTraits())
        )) {
            return $this->addLocaleOption($instance);
        }

        return $this->addOption($instance);
    }

    /**
     * Add an option to the container.
     *
     * @param  \Jalexcam\Fibber\Options\Option  $option
     *
     * @return Container
     */
    protected function addOption(Option $option): Container
    {
        if (isset(static::$options[$option->getName()])) {
            trigger_error(sprintf('[FIBBER] The \'%s\' extension is already registered', $option->getName()), E_USER_WARNING);
        }

        static::$options[$option->getName()] = $option;

        // Here we register all the extensions methods in order to have a quick access after
        foreach (get_class_methods($option) as $method) {
            // If the method is common
            if (in_array($method, ['getName', '__construct'])) {
                continue;
            }

            if (isset(static::$optionMethods[$method])) {
                trigger_error(sprintf('[FIBBER] The \'%s\' method from \'%s\' is already registered', $method, $option->getName()), E_USER_WARNING);
            }

            static::$optionMethods[$method] = $option->getName();
        }

        return $this;
    }

    /**
     * Add an extension to the container.
     *
     * @param  \Jalexcam\Fibber\Options\Option  $option
     *
     * @return static
     */
    protected function addLocaleOption(Option $option): static
    {
        if ( ! isset(static::$options[$option->getName()])) {
            static::$options[$option->getName()] = [
                'locales' => [],
            ];
        }

        if (isset(static::$Options[$option->getName()]['locales'][$option->getLocale()])) {
            trigger_error(sprintf('[XEFI FAKER] The \'%s\' option in locale \'%s\' is already registered', $option->getName(), $option->getLocale()), E_USER_WARNING);
        }

        static::$options[$option->getName()]['locales'][$option->getLocale()] = $option;

        // Here we register all the options methods in order to have a quick access after
        foreach (get_class_methods($option) as $method) {
            // If the method is common
            if (in_array($method, ['getName', '__construct'])) {
                continue;
            }

            // The method for another locale has been set
            if (isset(static::$optionMethods[$method])) {
                continue;
            }

            static::$optionMethods[$method] = $option->getName();
        }

        return $this;
    }

    /**
     * Get the container options.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return static::$options;
    }

    /**
     * Get the container options methods.
     *
     * @return array
     */
    public function getOptionMethods(): array
    {
        return static::$optionMethods;
    }

    /**
     * See if the options has already been set.
     *
     * @return bool
     */
    public function areOptionsInitialized(): bool
    {
        return ! empty(static::$options);
    }

    /**
     * Reset the container options.
     *
     * @return void
     */
    public function eraseExtensions(): void
    {
        static::$options = [];
        static::$optionMethods = [];
    }

    /**
     * Resolve the method called to options.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function callOptionMethod(string $method, array $parameters = [])
    {
        if ( ! isset(static::$optionMethods[$method])) {
            throw new BadMethodCallException(sprintf('The %s method does not exist', $method));
        }

        $option = static::$options[static::$optionMethods[$method]];

        // We assume we here have multiple extensions declined by locale, we will try
        // to get the extension with the current locale, defaulting to first element
        if (is_array($option) && isset($option['locales'])) {
            if ( ! isset($option['locales'][$this->getLocale()]) && ! isset($option['locales'][null])) {
                throw new NoOptionLocaleFoundException(sprintf('Locale \'%s\' and \'%s\' for method \'%s\' was not found', $this->getLocale(), Locales::DEFAULT, $method));
            }

            $option = $option['locales'][$this->getLocale()] ?? $option['locales'][Locales::DEFAULT];
        }

        return $option->{$method}(...$parameters);
    }
}