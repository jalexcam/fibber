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

namespace Fibber\Option;

/**
 * This option allow assign all the data related with a person.
 */
interface PersonOption extends Option
{
    public const GENDER_FEMALE = 'female';
    public const GENDER_MALE = 'male';

    /**
     * Get the name of a person.
     * 
     * @param  string|null  $gender
     * @return string
     */
    public function name(?string $gender = null): string;

    /**
     * Get the first name of a person.
     * 
     * @param  string|null  $gender
     * @return string
     */
    public function firstName(?string $gender = null): string;

    /**
     * Get the first name male.
     * 
     * @return string
     */
    public function firstNameMale(): string;

    /**
     * Get the first name female.
     * 
     * @return string
     */
    public function firstNameFemale(): string;

    /**
     * Get the lastname of a person.
     * 
     * @return string
     */
    public function lastName(): string;

    /**
     * Get the title.
     *
     * @param  string|null $gender 
     * @return string
     */
    public function title(?string $gender = null): string;

    /**
     * Get the title male.
     * 
     * @return string
     */
    public function titleMale(): string;

    /**
     * Get the title female.
     * 
     * @return string
     */
    public function titleFemale(): string;
}