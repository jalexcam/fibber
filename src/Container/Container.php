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

namespace Jalexcam\Fibber\Container;

use Closure;
use Jalexcam\Fibber\Exceptions\MaximumTriesReachedException;
use Jalexcam\Fibber\Container\Traits\HasOptions;
use Jalexcam\Fibber\Container\Traits\HasLocale;
use Jalexcam\Fibber\Container\Traits\HasStrategies;
use Jalexcam\Fibber\Manifests\ContainerMixinManifest;
use Jalexcam\Fibber\Manifests\PackageManifest;
use Jalexcam\Fibber\Providers\ProviderRepository;

/**
 * @mixin ContainerMixinManifest
 */
class Container
{
    use HasStrategies;
    use HasOptions;
    use HasLocale;

    /**
     * The container application bootstrappers.
     *
     * @var array
     */
    protected static array $bootstrappers = [];

    /**
     * The base path of the application.
     *
     * @var string
     */
    protected static string $basePath = './';

    /**
     * The manifest path where the providers will be stored.
     *
     * @var string
     */
    protected static string $packageManifestPath = 'packages.php';

    /**
     * The manifest path where the providers will be stored.
     *
     * @var string
     */
    protected static string $containerMixinManifestPath = './vendor/jalexcam/fibber/src/Container/ContainerMixin.php';

    /**
     * Create the container instance.
     *
     * @return void
     */
    public function __construct(bool $shouldBuildContainerMixin = true)
    {
        if ( ! $this->areOptionsInitialized()) {
            $this->registerConfiguredProviders();

            $this->bootstrap();
        }

        if ($shouldBuildContainerMixin) {
            $this->buildContainerMixinManifest();
        }
    }

    /**
     * Set the package manifest path.
     *
     * @param string $manifestPath
     *
     * @return void
     */
    public static function packageManifestPath(string $manifestPath): void
    {
        static::$packageManifestPath = $manifestPath;
    }

    /**
     * Set the container mixin manifest path.
     *
     * @param string  $containerMixinManifestPath
     *
     * @return void
     */
    public static function containerMixinManifestPath(string $containerMixinManifestPath): void
    {
        static::$containerMixinManifestPath = $containerMixinManifestPath;
    }

    /**
     * Set the base path.
     *
     * @param string $basePath
     *
     * @return void
     */
    public static function basePath(string $basePath)
    {
        static::$basePath = $basePath;
    }

    /**
     * Build container mixin manifest.
     * 
     * @return void
     */
    protected function buildContainerMixinManifest(): void
    {
        $containerMixinManifest = new ContainerMixinManifest(static::$basePath, static::$containerMixinManifestPath);
        $containerMixinManifest->buildIfShould($this->getOptionMethods(), $this->getOptions());
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    protected function registerConfiguredProviders(): void
    {
        $packageManifest = new PackageManifest(static::$basePath, static::$packageManifestPath);

        $providers = $packageManifest->providers();

        $collapsedProviders = [];

        foreach ($providers as $values) {
            $collapsedProviders[] = $values;
        }

        (new ProviderRepository())
            ->load(array_merge([], ...$collapsedProviders));
    }

    /**
     * Register a console "starting" bootstrapper.
     *
     * @param  Closure  $callback
     *
     * @return void
     */
    public static function starting(Closure $callback): void
    {
        static::$bootstrappers[] = $callback;
    }

    /**
     * Bootstrap the console application.
     *
     * @return void
     */
    protected function bootstrap()
    {
        foreach (static::$bootstrappers as $bootstrapper) {
            $bootstrapper($this);
        }
    }

    /**
     * Reset the bootstrappers.
     *
     * @return void
     */
    public function eraseBootstrappers(): void
    {
        static::$bootstrappers = [];
    }

    /**
     * Get the generated value.
     * 
     * @param  string  $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function run($method, $parameters)
    {
        $tries = 0;
        
        do {
            $generatedValue = $this->callOptionMethod($method, $parameters);

            if (++$tries > 20000) {
                throw new MaximumTriesReachedException(sprintf('Maximum tries of %d reached without finding a value', 20000));
            }
        } while ( ! $this->passStrategies($generatedValue));

        // Here we assume the container has done his job and reset the strategies
        // in case the user wants to run the method again on another extension
        $this->eraseStrategies();

        return $generatedValue;
    }

    /**
     * Magic method.
     * 
     * Dynamically call the option.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->run($method, $parameters);
    }
}