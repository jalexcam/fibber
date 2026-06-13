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

namespace Fibber\Container;

use InvalidArgumentException;

/**
 * Allows a factory implementation of a container.
 */
final class ContainerFactory
{
    /**
     * Get the definition using a list.
     * 
     * @var array<string, callable|object|string>
     */
    protected array $definitions;

    /**
     * Adds an id for choose a key the list of definitions.
     * 
     * @param string $id
     * @param callable|object|string $definition
     * 
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function add(string $id, $definition): static
    {
        if ( ! is_string($definition) && ! is_callable($definition) && ! is_object($definition)) {
            throw new InvalidArgumentException(sprintf(
                'First argument to "%s::add()" must be a string, callable or object.',
                self::class,
            ));
        }

        $this->definitions[$id] = $definition;

        return $this;
    }

    /**
     * Register a definitions with container.
     * 
     * @return ContainerInterface
     */
    public function build(): ContainerInterface
    {
        return new Container($this->definitions);
    }

    /**
     * Get the default options.
     * 
     * @return array
     */
    protected static function defaultOptions(): array
    {
        return [
            
        ];
    }

    /**
     * Get the default options with id.
     * 
     * @return static
     */
    public static function withDefaultOptions(): static
    {
        $instance = new static();

        foreach (self::defaultOptions() as $id => $definition) {
            $instance->add($id, $definition);
        }

        return $instance;
    }
}