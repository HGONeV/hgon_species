<?php

declare(strict_types=1);

namespace HGON\HgonSpecies\Command;

use Doctrine\DBAL\Exception as DatabaseException;
use HGON\HgonSpecies\Service\DdaLinkSeeder;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class SeedDdaLinksCommand extends Command
{
    public function __construct(private readonly DdaLinkSeeder $seeder)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('apply', null, InputOption::VALUE_NONE, 'Write missing links. Without this option the command is read-only.');
        $this->setHelp('Use -v to show each planned update with its local UID. Install the dda_link database field before running this command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $plan = $this->seeder->plan();
            $updates = $plan['updates'];
            $io->text(sprintf('Storage PID %d: %d verified, %d to populate, %d already populated.', $plan['pid'], $plan['total'], count($updates), $plan['existing']));
            if ($plan['preserved'] !== []) {
                $io->note('Existing links differ from the source and will be preserved: ' . implode(', ', $plan['preserved']));
            }
            if ($output->isVerbose() && $updates !== []) {
                $io->table(['Slug', 'UID', 'DDA URL'], array_map(
                    static fn (string $slug, array $update): array => [$slug, $update[0]['uid'], $update[1]],
                    array_keys($updates),
                    $updates,
                ));
            }

            if (!$input->getOption('apply')) {
                $io->success('Dry run complete. Use --apply to populate the missing links.');
                return self::SUCCESS;
            }

            $io->success(sprintf('%d DDA links populated.', $this->seeder->apply($updates)));
            return self::SUCCESS;
        } catch (RuntimeException | DatabaseException $exception) {
            $io->error($exception->getMessage());
            return self::FAILURE;
        }
    }
}
