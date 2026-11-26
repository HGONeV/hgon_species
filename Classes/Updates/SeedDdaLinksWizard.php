<?php

declare(strict_types=1);

namespace HGON\HgonSpecies\Updates;

use Doctrine\DBAL\Exception as DatabaseException;
use HGON\HgonSpecies\Service\DdaLinkSeeder;
use RuntimeException;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\ChattyInterface;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('hgonSpeciesSeedDdaLinks')]
final class SeedDdaLinksWizard implements UpgradeWizardInterface, ChattyInterface
{
    private OutputInterface $output;

    public function __construct(private readonly DdaLinkSeeder $seeder) {}

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    public function getTitle(): string
    {
        return 'HGON-Artenliste: DDA-Links für Vogelporträts ergänzen';
    }

    public function getDescription(): string
    {
        return 'Ordnet die mitgelieferten DDA-Links anhand von Slug und wissenschaftlichem Namen zu und befüllt leere Felder. Vorhandene Links bleiben erhalten.';
    }

    public function updateNecessary(): bool
    {
        try {
            return $this->seeder->plan()['updates'] !== [];
        } catch (RuntimeException | DatabaseException) {
            // Keep the wizard visible so its run can report why the import is blocked.
            return true;
        }
    }

    public function executeUpdate(): bool
    {
        try {
            $plan = $this->seeder->plan();
            $count = $this->seeder->apply($plan['updates']);
            $this->output->writeln(sprintf('%d DDA-Links ergänzt. %d vorhandene Links beibehalten.', $count, $plan['existing']));
            return true;
        } catch (RuntimeException | DatabaseException $exception) {
            $this->output->writeln($exception->getMessage());
            return false;
        }
    }

    public function getPrerequisites(): array
    {
        return [DatabaseUpdatedPrerequisite::class];
    }
}
