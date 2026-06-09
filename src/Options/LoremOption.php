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

/**
 * Allows return the lorem a random.
 */
class LoremOption extends Option
{
    /**
     * List the latin words.
     * 
     * @var array
     */
    protected array $latinWords = [
        'amor', 'bellum', 'civitas', 'domus', 'fortuna', 'gloria', 'homo', 'imperium', 'libertas', 'luna',
        'magnus', 'natura', 'orbis', 'pax', 'regina', 'sapiens', 'terra', 'urbs', 'virtus', 'vita',
        'aqua', 'arbor', 'caelum', 'deus', 'equus', 'felix', 'gens', 'hostis', 'ignis', 'iustitia',
        'labor', 'mare', 'nox', 'opus', 'poena', 'rex', 'scelus', 'tempus', 'umbra', 'veritas',
        'victoria', 'voluntas', 'aetas', 'audacia', 'canis', 'corpus', 'dies', 'fatum', 'herba', 'insula',
        'lex', 'lux', 'mens', 'mors', 'navis', 'numerus', 'ordo', 'parens', 'populus', 'proelium',
        'quies', 'sanguis', 'senex', 'silva', 'sol', 'somnus', 'stella', 'tempestas', 'timor', 'vates',
        'verbum', 'vinculum', 'animus', 'aurum', 'carmen', 'certamen', 'cogitatio', 'cura', 'fides',
        'gaudium', 'ignavia', 'lacrima', 'ludus', 'murus', 'nomen', 'odium', 'penna', 'pontus', 'ratio',
        'saxum', 'servus', 'sponsa', 'templum', 'vallis', 'ver', 'vulnus', 'aestas', 'caput', 'castra',
        'dolor', 'ferrum', 'forma', 'frater', 'genus', 'locus', 'mater', 'mons', 'niger', 'oculus',
        'pater', 'porta', 'puella', 'res', 'soror', 'tectum', 'via', 'vinum', 'acer', 'altus',
        'bonus', 'brevis', 'clarus', 'dexter', 'durus', 'facilis', 'fortis', 'gravis', 'iuvenis', 'longus',
        'malus', 'medius', 'mirus', 'novus', 'parvus', 'primus', 'sanctus', 'severus', 'solus', 'tutus',
        'validus', 'velox', 'verus', 'vividus', 'arma', 'auris', 'cibus', 'dolus', 'fama',
        'filia', 'fuga', 'hora', 'ira', 'lacus', 'latus', 'mensa', 'morbus', 'portus', 'rosa',
        'scutum', 'acumen', 'aureus', 'avis', 'bellus', 'caritas', 'celer', 'certus', 'civis', 'comitas',
        'cupiditas', 'dignitas', 'femina', 'finis', 'flamma', 'fructus', 'gratia', 'ignotus', 'innocens', 'ius',
        'liber', 'lingua', 'lumen', 'magnitudo', 'mensis', 'minimus', 'modus', 'mulier', 'munus', 'nasus',
        'natio', 'nefas', 'nobilis', 'occasio', 'officium', 'onus', 'pars', 'passio', 'pecunia', 'potestas',
        'praemium', 'regnum', 'sacrificium', 'scientia', 'sermo', 'signum', 'species', 'spes', 'tenebrae',
        'terrae', 'usus', 'ventus', 'victor', 'villa', 'votum', 'vulgaris', 'aeger', 'aquaeductus', 'bona',
        'celeritas', 'corona', 'credo', 'cubiculum', 'decus', 'delirium', 'dens', 'digitus', 'educatio', 'exemplum',
        'fidelitas', 'flos',
    ];

    /**
     * Get the word.
     * 
     * @return string
     */
    public function word(): string
    {
        return $this->pickArrayRandomElement($this->latinWords);
    }

    /**
     * Returns words the given a array.
     * 
     * @param  int  $words
     * 
     * @return array
     */
    public function words(int $words = 3): array
    {
        return $this->pickArrayRandomOfKeyElements($this->latinWords, $words);
    }

    /**
     * Get a sentence.
     * 
     * @param  int  $words
     * 
     * @return string 
     */
    public function sentence(int $words = 6): string
    {
        return implode(' ', $this->words($words));
    }
}