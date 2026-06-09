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

namespace Jalexcam\Fibber\Exceptions;

use Throwable;
use RuntimeException;

/**
 * The message of exception: maximum tries reached.
 */
class MaximumTriesReachedException extends RuntimeException
{
    /**
     * Constructor. Create a new MaximumTriesReachedException instance.
     * 
     * @param  string  $message
     * @param  int  $code
     * @param  Throwable|null  $previous
     * 
     * @return void
     */
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}