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

namespace Jalexcam\Fibber\Options\Traits;

use Jalexcam\Fibber\Container\Enum\Locales;

/**
 * Trait allow has locale.
 */
trait HasLocale
{
    /**
     * The extension locale (BCP 47 Code).
     *
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return Locales::DEFAULT;
    }
}