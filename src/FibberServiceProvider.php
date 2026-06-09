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

namespace Jalexcam\Fibber;

use Jalexcam\Fibber\Options\DateTimeOption;
use Jalexcam\Fibber\Options\HashOption;
use Jalexcam\Fibber\Options\LoremOption;
use Jalexcam\Fibber\Options\NumbersOption;
use Jalexcam\Fibber\Options\PersonOption;
use Jalexcam\Fibber\Options\StringsOption;
use Jalexcam\Fibber\Providers\ServiceProvider;

/**
 * For loading the classes from the container of services.
 */
class FibberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     * 
     * @return void
     */
    public function boot(): void
    {
        $this->register([
            LoremOption::class,
            NumbersOption::class,
            StringsOption::class,
            HashOption::class,
            DateTimeOption::class,
            PersonOption::class,
        ]);
    }
}