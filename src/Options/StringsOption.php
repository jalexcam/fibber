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

/**
 * Allows return values ​strings.
 */
class StringsOption extends Option
{
    /**
     * List of emojis.
     * 
     * @var array
     */
    protected array $emojis = [
        "\u{1F600}", "\u{1F601}", "\u{1F602}", "\u{1F603}",
        "\u{1F604}", "\u{1F605}", "\u{1F606}", "\u{1F607}",
        "\u{1F608}", "\u{1F609}", "\u{1F60A}", "\u{1F60B}",
        "\u{1F60C}", "\u{1F60D}", "\u{1F60E}", "\u{1F60F}",
        "\u{1F610}", "\u{1F611}", "\u{1F612}", "\u{1F613}",
        "\u{1F614}", "\u{1F615}", "\u{1F616}", "\u{1F617}",
        "\u{1F618}", "\u{1F619}", "\u{1F61A}", "\u{1F61B}",
        "\u{1F61C}", "\u{1F61D}", "\u{1F61E}", "\u{1F61F}",
        "\u{1F620}", "\u{1F621}", "\u{1F622}", "\u{1F623}",
        "\u{1F624}", "\u{1F625}", "\u{1F626}", "\u{1F627}",
        "\u{1F628}", "\u{1F629}", "\u{1F62A}", "\u{1F62B}",
        "\u{1F62C}", "\u{1F62D}", "\u{1F62E}", "\u{1F62F}",
        "\u{1F630}", "\u{1F631}", "\u{1F632}", "\u{1F633}",
        "\u{1F634}", "\u{1F635}", "\u{1F636}", "\u{1F637}",
        "\u{1F638}", "\u{1F639}", "\u{1F63A}", "\u{1F63B}",
        "\u{1F63C}", "\u{1F63D}", "\u{1F63E}", "\u{1F63F}",
        "\u{1F640}", "\u{1F641}", "\u{1F642}", "\u{1F643}",
        "\u{1F644}", "\u{1F645}", "\u{1F646}", "\u{1F647}",
        "\u{1F648}", "\u{1F649}", "\u{1F64A}", "\u{1F64B}",
        "\u{1F64C}", "\u{1F64D}", "\u{1F64E}", "\u{1F64F}",
    ];

    /**
     * Get the letter of a string.
     * 
     * @return string
     */
    public function letter(): string
    {
        return chr($this->randomizer->getInt(97, 122));
    }

    /**
     * Get the shuffle of a string.
     * 
     * @param  array|string  $needle
     * 
     * @return array|string
     */
    public function shuffle(array|string $needle): array|string
    {
        return $this->{'shuffle'.gettype($needle)}($needle);
    }

    /**
     * Get a byte-wise permutation of a string.
     * 
     * @param  string  $needle
     * 
     * @return string
     */
    public function shuffleString(string $needle): string
    {
        return $this->randomizer->shuffleBytes($needle);
    }

    /**
     * Get a permutation of an array.
     * 
     * @param  array  $needle
     * 
     * @return array
     */
    public function shuffleArray(array $needle): array
    {
        return $this->randomizer->shuffleArray($needle);
    }

    /**
     * Convert characters the given a string.
     * 
     * @param  string  $string
     * 
     * @return string
     */
    public function convertCharacters(string $string): string
    {
        $patterns = [
            '#' => fn () => $this->randomizer->getInt(0, 9),
            '?' => fn () => $this->letter(),
        ];

        $patterns['*'] = fn () => $this->pickArrayRandomElement($patterns)();

        for ($i = 0; $i < strlen($string); $i++) {
            $string[$i] = isset($patterns[$string[$i]]) ? $patterns[$string[$i]]() : $string[$i];
        }

        return $string;
    }

    /**
     * Get a uniformly selected integer.
     * 
     * @return string
     */
    public function selectInteger(): string
    {
        return sprintf(
            '%d.%d.%d',
            $this->randomizer->getInt(0, 9),
            $this->randomizer->getInt(0, 99),
            $this->randomizer->getInt(0, 99)
        );
    }

    /**
     * Get a emoji.
     * 
     * @return string
     */
    public function emoji(): string
    {
        return $this->pickArrayRandomElement($this->emojis);
    }
}