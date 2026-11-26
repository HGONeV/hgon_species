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

    public function getXenoCantoRecordingId(): string
    {
        $link = trim((string)$this->getCustomLink());
        // Some existing records contain the embed markup instead of the recording URL.
        if (preg_match('~\A<iframe\b[^>]*\s+src\s*=\s*(["\'])([^"\']+)\1[^>]*>\s*</iframe>\z~i', $link, $iframe) === 1) {
            $link = $iframe[2];
        } else {
            // TYPO3 link fields may append a target and other typolink parameters.
            $link = preg_split('/\s+/', $link, 2)[0];
        }

        if (preg_match('~\Ahttps?://(?:www\.)?xeno-canto\.org/([0-9]+)(?:/embed)?/?(?:[?#][^\s<>"\']*)?\z~i', $link, $recording) === 1) {
            return $recording[1];
        }

        return '';
    }

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
