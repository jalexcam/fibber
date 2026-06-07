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
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@Lenevor.com so we can send you a copy immediately.
 *
 * @package     Fibber
 * @link        https://fibberpackage.com
 * @copyright   Copyright (c) 2026 Alexander Campo <jalexcam@gmail.com>
 * @license     https://opensource.org/licenses/BSD-3-Clause New BSD license or see https://fibberpackage.com/license
 */

namespace Lenevor\Fibber\Options;

use Lenevor\Options\Traits\HasLocale;

/**
 * Allows return values ​​about a person's first and last name.
 */
class PersonOption extends Option
{
    use HasLocale;

    public const GENDER_MALE = 'M';
    public const GENDER_FEMALE = 'F';

    /**
     * List of first name male.
     * 
     * @var array
     */
    protected array $firstNameMale = [
        'Alexander', 'Germanicus',
        'Marcus', 'Lucius', 'Gaius',
        'Julius', 'Titus', 'Quintus',
        'Octavius', 'Sextus', 'Maximus',
        'Aurelius', 'Flavius', 'Cesar',
        'Majorian', 'Trajan', 'Paulus',
        'Plubius', 'Tiberius', 'Manius',
        'Decimus', 'Servius', 'Spurius',
        'Aulus', 'Appius', 'Numerius',
        'Valerius', 'Pompeius', 'Ulpius',
        'Antonius', 'Aelius', 'Aurelius',
    ];

    /**
     * List of first name females.
     * 
     * @var array
     */
    protected array $firstNameFemale = [
        'Julia', 'Silvana', 'Regina',
        'Emilia', 'Octavia', 'Fabia',
        'Lucilla', 'Claudia', 'Livia',
        'Aemilia', 'Cornelia', 'Flavia',
        'Antonia', 'Octavia', 'Valeria',
        'Aquila', 'Marcella', 'Agrippina',
        'Felicia', 'Priscilla', 'Demetria',
        'Septima', 'Portia', 'Sabina',
        'Ursula', 'Isadora', 'Augusta',
        'Faustina', 'Junia', 'Ovidia',
        'Prisca', 'Leonia', 'Lavinia',  
    ];

    /**
     * List of lastnames.
     * 
     * @var array
     */
    protected array $lastName = [
        'Scipio', 'Brutus', 'Gracchus',
        'Cicero', 'Sulla', 'Trajanus',
        'Vespasianus', 'Agrippa', 'Lentulus',
        'Nerva', 'Cato', 'Aurelius',
        'Horace', 'Nero', 'Calvin',
        'Tacitus', 'Seneca', 'Pompey',
        'Livy', 'Ovid', 'Calvin',
        'Augustus', 'Aventinus', 'Messalla',
        'Sabinus', 'Corvus', 'Picentinus',
        'Sicilianus', 'Gallicanus', 'Hispanus',
        'Capiton', 'Italicus', 'Tiburtinus',
    ];

    /**
     * List of title male.
     * 
     * @var array
     */
    protected array $titleMale = [
        'Dominus',
        'Doctor',
        'Professor',
    ];

    /**
     * List of title female.
     * 
     * @var array
     */
    protected array $titleFemale = [
        'Domina',
        'Doctor',
        'Professor',
    ];

    /**
     * Get the name complete of person.
     * 
     * @param  string|null  $gender
     * 
     * @return string
     */
    public function name(string|null $gender = null): string
    {
        return sprintf('%s %s', $this->firstName($gender), $this->lastName());
    }
    
    /**
     * Get the first name of person depending on whether it is female or male.
     * 
     * @param  string|null  $gender
     * 
     * @return string
     */
    public function firstName(string|null $gender = null): string
    {
        if ($gender === static::GENDER_MALE) {
            return $this->pickArrayRandomElement($this->firstNameMale);
        }

        if ($gender === static::GENDER_FEMALE) {
            return $this->pickArrayRandomElement($this->firstNameFemale);
        }

        return $this->pickArrayRandomElement($this->randomizer->getInt(0, 1) === 0 ? $this->firstNameFemale : $this->firstNameMale);
    }

    /**
     * Get the lastname of person.
     * 
     * @return string
     */
    public function lastName(): string
    {
        return $this->pickArrayRandomElement($this->lastName);
    }

    /**
     * Get the title of person depending on whether it is female or male.
     * 
     * @param  mixed  $gender
     * 
     * @return mixed
     */
    public function title($gender = null)
    {
        if ($gender === static::GENDER_MALE) {
            return $this->pickArrayRandomElement($this->titleMale);
        }

        if ($gender === static::GENDER_FEMALE) {
            return $this->pickArrayRandomElement($this->titleFemale);
        }

        return $this->pickArrayRandomElement($this->randomizer->getInt(0, 1) === 0 ? $this->titleFemale : $this->titleMale);
    }
}