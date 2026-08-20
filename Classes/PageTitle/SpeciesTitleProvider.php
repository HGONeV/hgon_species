<?php

declare(strict_types=1);

namespace HGON\HgonSpecies\PageTitle;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

final class SpeciesTitleProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
