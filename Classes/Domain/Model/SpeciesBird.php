<?php
namespace HGON\HgonSpecies\Domain\Model;

/***
 *
 * This file is part of the "HgonSpecies" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2025 Maximilian Fäßler <maximilian@faesslerweb.de>, Fäßler Web UG
 *
 ***/

/**
 * SpeciesBird
 */
class SpeciesBird extends Species
{
    protected string $ddaLink = '';

    public function getDdaLink(): string
    {
        return self::isDdaPortraitUrl($this->ddaLink) ? $this->ddaLink : '';
    }

    public function setDdaLink(string $ddaLink): void
    {
        $this->ddaLink = trim($ddaLink);
    }

    public static function isDdaPortraitUrl(string $url): bool
    {
        return strlen($url) <= 255
            && preg_match('~^https://(?:www\.)?dda-web\.de/voegel/voegel-in-deutschland/[^\s/\\\\?#]+$~uD', $url) === 1;
    }
}
