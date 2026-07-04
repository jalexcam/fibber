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

use Fibber\Option\PersonOption;

/**
 * Allows the extract data of a person. 
 */
class Person extends Base implements PersonOption
{
    protected static $firstNameMale = [
        'John',
    ];

    protected static $firstNameFemale = [
        'Jane',
    ];

    protected static $lastName = ['Doe'];

    protected static $titleMale = ['Mr.', 'Dr.', 'Prof.'];

    protected static $titleFemale = ['Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.'];

    /**
     * Get the name of a person.
     * 
     * @param  string|null  $gender 
     * @return string
     */
    public function name(?string $gender = null): string
    {
        return '';
    }

    /**
     * Get the first name of a person.
     * 
     * @param  string|null  $gender 
     * @return string
     */
    public function firstName(?string $gender = null): string
    {
        return '';
    }

    /**
     * Get the first name male.
     * 
     * @return string
     */
    public function firstNameMale(): string
    {
        return $this->getArrayRandomElement(static::$firstNameMale);
    }

    /**
     * Get the first name female.
     * 
     * @return string
     */
    public function firstNameFemale(): string
    {
        return $this->getArrayRandomElement(static::$firstNameFemale);
    }

    /**
     * Get the lastname of a person.
     * 
     * @return string
     */
    public function lastName(): string
    {
        return $this->getArrayRandomElement(static::$lastName);
    }

    /**
     * Get the title.
     *
     * @param  string|null  $gender
     * @return string
     */
    public function title(?string $gender = null): string
    {
        if ($gender === static::GENDER_MALE) {
            return static::titleMale();
        }

        if ($gender === static::GENDER_FEMALE) {
            return static::titleFemale();
        }

        return '';
    }

    /**
     * Get the title male.
     * 
     * @return string
     */
    public function titleMale(): string
    {
        return $this->getArrayRandomElement(static::$titleMale);
    }

    /**
     * Get the title female.
     * 
     * @return string
     */
    public function titleFemale(): string
    {
        return $this->getArrayRandomElement(static::$titleFemale);
    }
}