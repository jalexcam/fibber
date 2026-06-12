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

use Fibber\Container\Exception\ContainerException;
use Throwable;
use Fibber\Container\Exception\NotFoundContainerException;
use InvalidArgumentException;
use RuntimeException;

/**
 * Allows a simple implementation of a container.
 */
final class Container implements ContainerInterface
{
    /**
     * Get the definition using a list.
     * 
     * @var array<string, callable|object|string>
     */
    protected array $definitions;

    /**
     * Get all the services.
     * 
     * @var array<string, object>
     */
    protected array $services = [];

    /**
     * Constructor. Create a new Container instance.
     * 
     * @param array<string, callable|object|string> $definitions
     * 
     * @return void
     */
    public function __construct(array $definitions)
    {
        $this->definitions = $definitions;
    }

    /**
     * Retrieve a definition from the container.
     *
     * @param string $id
     * 
     * @return mixed
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ContainerException
     * @throws NotFoundContainerException
     */
    public function get($id)
    {
        if ( ! is_string($id)) {
            throw new InvalidArgumentException(sprintf(
                'First argument of %s::get() must be string',
                self::class,
            ));
        }

        if (array_key_exists($id, $this->services)) {
            return $this->services[$id];
        }

        if ( ! $this->has($id)) {
            throw new NotFoundContainerException(sprintf(
                'There is no service with id "%s" in the container.',
                $id,
            ));
        }

        $definition = $this->definitions[$id];

        $service = $this->getService($id, $definition);

        if ( ! is_object($service)) {
            throw new RuntimeException(sprintf(
                'Service resolved for identifier "%s" is not an object.',
                $id,
            ));
        }

        $this->services[$id] = $service;

        return $service;
    }

    /**
     * Get the service from a definition.
     *
     * @param string $id
     * @param callable|object|string $definition
     * 
     * @return mixed
     */
    private function getService(string $id, $definition)
    {
        if (is_callable($definition)) {
            try {
                return $definition($this);
            } catch (Throwable $e) {
                throw new ContainerException(
                    sprintf('Error while invoking callable for "%s"', $id),
                    0,
                    $e,
                );
            }
        } elseif (is_object($definition)) {
            return $definition;
        } elseif (is_string($definition)) {
            if (class_exists($definition)) {
                try {
                    return new $definition();
                } catch (Throwable $e) {
                    throw new ContainerException(sprintf('Could not instantiate class "%s"', $id), 0, $e);
                }
            }

            throw new ContainerException(sprintf(
                'Could not instantiate class "%s". Class was not found.',
                $id,
            ));
        } else {
            throw new ContainerException(sprintf(
                'Invalid type for definition with id "%s"',
                $id,
            ));
        }
    }

    /**
     * Check if the container contains a given identifier.
     *
     * @param string $id
     * 
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function has($id): bool
    {
        if ( ! is_string($id)) {
            throw new InvalidArgumentException(sprintf(
                'First argument of %s::get() must be string',
                self::class,
            ));
        }

        return array_key_exists($id, $this->definitions);
    }
}