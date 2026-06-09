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

/**
 * Trait HasLocale.
 */
trait HasLocale
{
    /**
     * The current locale format (BCP 47 Code).
     *
     * @var string|null
     */
    protected string|null $locale;

    /**
     * Get the current locale.
     *
     * @return string|null
     */
    public function getLocale(): string|null
    {
        return $this->locale ?? null;
    }

    /**
     * Change the locale.
     *
     * @param  string|null  $locale
     *
     * @return static
     */
    public function locale(string|null $locale): static
    {
        $this->locale = $locale;

        return $this;
    }
}