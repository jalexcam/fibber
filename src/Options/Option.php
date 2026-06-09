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

namespace Jalexcam\Fibber\Options;

use Random\Randomizer;
use ReflectionClass;

/**
 * Allows return a random element.
 */
class Option
{
    /**
     * The randomness provided.
     * 
     * @var Randomizer
     */
    protected Randomizer $randomizer;

    /**
     * Constructor. Create a new Option instance.
     * 
     * @param  Randomizer  $randomizer
     * 
     * @return void
     */
    public function __construct(Randomizer $randomizer)
    {
        $this->randomizer = $randomizer;
    }

    /**
     * Gets the extension name.
     *
     * @return string
     */
    public function getName(): string
    {
        return
            strtolower(
                preg_replace(
                    '/([a-z])([A-Z])/',
                    '$1-$2',
                    (new ReflectionClass($this))->getShortName()
                )
            );
    }

    /**
     * Return a given number of random elements from the given array.
     *
     * @param  array  $array
     * @param  int  $elements
     *
     * @return array
     */
    protected function pickArrayRandomOfKeyElements(array $array, int $elements = 1): array
    {
        $keys = $this->randomizer->pickArrayKeys($array, $elements);

        return array_intersect_key($array, array_flip($keys));
    }

    /**
     * Return a random element from the given array.
     *
     * @param array $array
     *
     * @return mixed
     */
    protected function pickArrayRandomElement(array $array): mixed
    {
        $elements = $this->pickArrayRandomOfKeyElements($array);

        return reset($elements);
    }

    /**
     * Return a random element from the given array with key.
     * 
     * @param  array  $array
     * 
     * @return mixed
     */
    protected function pickArrayRandomKey(array $array): mixed
    {
        return $this->pickArrayRandomKeys($array)[0];
    }

    /**
     * Return a random element from the given array with a keys group.
     * 
     * @param  array  $array
     * @param  int  $elements
     * 
     * @return array 
     */
    protected function pickArrayRandomKeys(array $array, int $elements = 1): array
    {
        return $this->randomizer->pickArrayKeys($array, $elements);
    }

    /**
     * Get the format of string from a position.
     * 
     * @param  string  $string
     * 
     * @return string 
     */
    protected function formatString(string $string): string
    {
        while (($position = strpos($string, '{a}')) !== false) {
            $string = substr_replace($string, $this->pickArrayRandomElement(['{d}', '{l}']), $position, 3);
        }

        while (($position = strpos($string, '{d}')) !== false) {
            $string = substr_replace($string, (string) $this->randomizer->getInt(0, 9), $position, 3);
        }

        while (($position = strpos($string, '{l}')) !== false) {
            $string = substr_replace($string, $this->randomizer->getBytesFromString(implode(range('A', 'Z')), 1), $position, 3);
        }

        return $string;
    }
}