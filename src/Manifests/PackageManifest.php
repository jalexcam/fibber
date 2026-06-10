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

namespace Jalexcam\Fibber\Manifests;

use Exception;

/**
 * Allows create a file of package manifest.
 */
class PackageManifest
{
    /**
     * The base path.
     *
     * @var string
     */
    public string $basePath;
    
    /**
     * The loaded manifest array.
     *
     * @var array
     */
    public array $manifest;
    
    /**
     * The manifest path.
     *
     * @var string|null
     */
    public string|null $manifestPath;

    /**
     * The vendor path.
     *
     * @var string
     */
    public string $vendorPath;

    /**
     * Constructor. Create a new package manifest instance.
     *
     * @param  string  $basePath
     * @param  string  $manifestPath
     *
     * @return void
     */
    public function __construct(string $basePath, string $manifestPath)
    {
        $this->basePath = $basePath;
        $this->vendorPath = $basePath.'/vendor';
        $this->manifestPath = $manifestPath;
    }

    /**
     * Get all of the service provider class names for all packages.
     *
     * @return array
     */
    public function providers(): array
    {
        return $this->config('providers');
    }

    /**
     * Get all of the values for all packages for the given configuration name.
     *
     * @param  string  $key
     *
     * @return array
     */
    public function config($key): array
    {
        return array_filter(
            array_map(
                function ($configuration) use ($key) {
                    return (array) ($configuration[$key] ?? []);
                },
                $this->getManifest()
            )
        );
    }

    /**
     * Get the current package manifest.
     *
     * @return array
     */
    protected function getManifest(): array
    {
        if ( ! empty($this->manifest)) {
            return $this->manifest;
        }

        if ($this->shouldRecompile()) {
            $this->build();
        }

        return $this->manifest = is_file($this->manifestPath) ?
            (require $this->manifestPath) : [];
    }

    /**
     * Build the manifest and write it to disk.
     *
     * @return void
     */
    public function build(): void
    {
        $packages = [];

        if (is_file($path = $this->vendorPath.'/composer/installed.json')) {
            $installed = json_decode(file_get_contents($path), true);

            $packages = $installed['packages'] ?? $installed;
        }

        $packagesToProvide = [];

        foreach ($packages as $package) {
            if (isset($package['extra']['fibber'])) {
                $packagesToProvide[$package['name']] = $package['extra']['fibber'];
            }
        }

        $this->write($packagesToProvide);
    }

    /**
     * Determine if the manifest should be compiled.
     *
     * @return bool
     */
    public function shouldRecompile(): bool
    {
        return ! is_file($this->manifestPath) ||
            // We check here if the manifest has been generated before changing the installed.json composer file
            filemtime($this->manifestPath) <= filemtime($this->vendorPath.'/composer/installed.json');
    }

    /**
     * Write the given manifest array to disk.
     *
     * @param  array  $manifest
     *
     * @return void
     * 
     * @throws Exception
     */
    protected function write(array $manifest): void
    {
        if ( ! is_writable($dirname = dirname($this->manifestPath))) {
            throw new Exception("The {$dirname} directory must be present and writable.");
        }

        file_put_contents(
            $this->manifestPath,
            '<?php return '.var_export($manifest, true).';'
        );
    }
}