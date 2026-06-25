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

namespace Fibber\Provider\Options;

use Random\Randomizer;
use ReflectionClass;

/**
 * Allows generate a random of element from the given an array.
 */
class Base
{
    /**
     * Get the random of data.
     * 
     * @var Randomizer
     */
    protected Randomizer $randomizer;

    /**
     * Constructor. Create a new Base instance.
     * 
     * @param Randomizer $randomizer
     * 
     * @return void
     */
    public function __construct(Randomizer $randomizer)
    {
        $this->randomizer = $randomizer;
    }

    /**
     * Returns the extension name.
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
     * @param array $array
     * @param int $elements
     *
     * @return array
     */
    protected function getArrayRandomElements(array $array, int $elements = 1): array
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
    protected function getArrayRandomElement(array $array): mixed
    {
        $elements = $this->getArrayRandomElements($array);

        return reset($elements);
    }

    /**
     * Return a random keys from the given array.
     * 
     * @param array $array
     * @param int $elements
     * 
     * @return array
     */
    protected function getArrayRandomKeys(array $array, int $elements = 1): array
    {
        return $this->randomizer->pickArrayKeys($array, $elements);
    }

    /**
     * Return a number of first key random from the given array.
     * 
     * @param array $array
     * 
     * @return mixed
     */
    protected function getArrayRandomKey(array $array): mixed
    {
        return $this->getArrayRandomKeys($array)[0];
    }

    /**
     * Get the format string.
     * 
     * @param string $string
     * 
     * @return string
     */
    protected function formatString(string $string): string
    {
        while (($pos = strpos($string, '{a}')) !== false) {
            $string = substr_replace($string, $this->getArrayRandomElement(['{d}', '{l}']), $pos, 3);
        }

        while (($pos = strpos($string, '{d}')) !== false) {
            $string = substr_replace($string, (string) $this->randomizer->getInt(0, 9), $pos, 3);
        }

        while (($pos = strpos($string, '{l}')) !== false) {
            $string = substr_replace(
                $string, 
                $this->randomizer->getBytesFromString(implode(range('A', 'Z')), 1), 
                $pos, 
                3
            );
        }

        return $string;
    }
}