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

use InvalidArgumentException;

/**
 * Allows the call of providers.
 */
class Factory
{
    public const DEFAULT_LOCALE = 'en_US';

    /**
     * Get the default providers.
     * 
     * @var array
     */
    protected static $defaultProviders = ['Person'];

    /**
     * Create a new generator.
     *
     * @param string $locale
     *
     * @return Generator
     */
    public static function create($locale = self::DEFAULT_LOCALE)
    {
        $generator = new Generator();

        foreach (static::$defaultProviders as $provider) {
            $providerClassName = static::getProviderClassname($provider, $locale);
            $generator->addProvider(new $providerClassName($generator));
        }

        return $generator;
    }

    /**
     * Get the provider of classname.
     * 
     * @param string $provider
     * @param string $locale
     *
     * @return string
     */
    protected static function getProviderClassname($provider, $locale = ''): string
    {
        if ($providerClass = static::findProviderClassname($provider, $locale)) {
            return $providerClass;
        }

        // fallback to default locale
        if ($providerClass = static::findProviderClassname($provider, static::DEFAULT_LOCALE)) {
            return $providerClass;
        }

        // fallback to no locale
        if ($providerClass = static::findProviderClassname($provider)) {
            return $providerClass;
        }

        throw new InvalidArgumentException(sprintf('Unable to find provider "%s" with locale "%s"', $provider, $locale));
    }

    /**
     * Get the find provider of classname.
     * 
     * @param string $provider
     * @param string $locale
     *
     * @return string|null
     */
    protected static function findProviderClassname($provider, $locale = '')
    {
        $providerClass = 'Fibber\\'.($locale ? sprintf('Provider\Locales\%s\%s', $locale, $provider) : sprintf('Provider\Options\%s', $provider));

        if (class_exists($providerClass, true)) {
            return $providerClass;
        }

        return null;
    }
}