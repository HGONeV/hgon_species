<?php

declare(strict_types=1);

namespace HGON\HgonSpecies\Service;

use HGON\HgonSpecies\Domain\Model\SpeciesBird;
use RuntimeException;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class DdaLinkSeeder
{
    private const TABLE = 'tx_hgonspecies_domain_model_species';
    private const ORIGINAL_BIRD = ['record_type' => 'bird', 'deleted' => 0, 't3ver_wsid' => 0, 't3ver_oid' => 0, 'l10n_parent' => 0];

    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly CacheManager $cacheManager,
    ) {}

    /** @return array{pid: int, total: int, existing: int, preserved: list<string>, updates: array<string, array{array, string}>} */
    public function plan(): array
    {
        $links = $this->loadLinks();
        $connection = $this->connectionPool->getConnectionForTable(self::TABLE);
        $records = $this->findOriginalBirds($connection);
        $errors = [];
        $pids = [];
        $updates = [];
        $existing = [];

        foreach ($links as $slug => [$scientificName, $url]) {
            $candidates = $records[$slug] ?? [];
            if (count($candidates) !== 1) {
                $errors[] = sprintf('%s: expected one original bird, found %d.', $slug, count($candidates));
                continue;
            }

            $record = $candidates[0];
            if (self::normalizeName($record['name_science']) !== self::normalizeName($scientificName)) {
                $errors[] = sprintf('%s (UID %d): expected %s, found %s.', $slug, $record['uid'], $scientificName, $record['name_science']);
                continue;
            }
            $pids[(int)$record['pid']] = true;

            if ($record['dda_link'] !== '') {
                $existing[$slug] = $record['dda_link'] === $url;
                continue;
            }
            $updates[$slug] = [$record, $url];
        }

        if (count($pids) !== 1) {
            $errors[] = 'The matched birds must belong to exactly one storage folder.';
        }
        if ($errors !== []) {
            throw new RuntimeException(implode("\n", $errors));
        }

        return [
            'pid' => array_key_first($pids),
            'total' => count($links),
            'existing' => count($existing),
            'preserved' => array_keys($existing, false, true),
            'updates' => $updates,
        ];
    }

    public function apply(array $updates): int
    {
        if ($updates !== []) {
            $this->writeLinks($this->connectionPool->getConnectionForTable(self::TABLE), $updates);
            $this->cacheManager->flushCachesInGroup('pages');
        }

        return count($updates);
    }

    private function loadLinks(): array
    {
        $file = new \SplFileObject(__DIR__ . '/../../Resources/Private/Data/dda-bird-portraits.tsv');
        if (rtrim($file->fgets(), "\r\n") !== "slug\tscientific_name\tdda_url") {
            throw new RuntimeException('Unexpected DDA source header.');
        }

        $links = [];
        $urls = [];
        while (!$file->eof()) {
            $line = rtrim($file->fgets(), "\r\n");
            if ($line === '') {
                continue;
            }
            $columns = explode("\t", $line);
            [$slug, $scientificName, $url] = array_pad($columns, 3, '');
            if (count($columns) !== 3 || !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/D', $slug)
                || trim($scientificName) === '' || !SpeciesBird::isDdaPortraitUrl($url)
                || isset($links[$slug]) || isset($urls[$url])) {
                throw new RuntimeException(sprintf('Invalid or duplicate DDA mapping for "%s".', $slug));
            }
            $links[$slug] = [$scientificName, $url];
            $urls[$url] = true;
        }
        if ($links === []) {
            throw new RuntimeException('No DDA links found in the source file.');
        }

        return $links;
    }

    private function findOriginalBirds(Connection $connection): array
    {
        $query = $connection->createQueryBuilder();
        // Explicitly include hidden originals when checking slug uniqueness.
        $query->getRestrictions()->removeAll();
        $query->select('uid', 'pid', 'slug', 'name_science', 'sys_language_uid', 'dda_link')
            ->from(self::TABLE)
            ->where('uid > 0', 'pid > 0', 'sys_language_uid IN (0, -1)');
        foreach (self::ORIGINAL_BIRD as $column => $value) {
            $type = is_int($value) ? Connection::PARAM_INT : Connection::PARAM_STR;
            $query->andWhere($query->expr()->eq($column, $query->createNamedParameter($value, $type)));
        }

        $records = [];
        foreach ($query->executeQuery()->fetchAllAssociative() as $record) {
            $records[preg_replace('~^/~', '', $record['slug'])][] = $record;
        }
        return $records;
    }

    private function writeLinks(Connection $connection, array $updates): void
    {
        $connection->transactional(static function () use ($connection, $updates): void {
            foreach ($updates as $slug => [$record, $url]) {
                // Recheck the identity and empty link atomically to preserve concurrent edits.
                $written = $connection->update(self::TABLE, ['dda_link' => $url, 'tstamp' => time()], self::ORIGINAL_BIRD + [
                    'uid' => (int)$record['uid'],
                    'pid' => (int)$record['pid'],
                    'slug' => $record['slug'],
                    'name_science' => $record['name_science'],
                    'sys_language_uid' => (int)$record['sys_language_uid'],
                    'dda_link' => '',
                ]);
                if ($written !== 1) {
                    throw new RuntimeException(sprintf('%s (UID %d) changed during the update. All changes were rolled back.', $slug, $record['uid']));
                }
            }
        });
    }

    private static function normalizeName(string $name): string
    {
        return mb_strtolower(trim(preg_replace('/\s+/u', ' ', $name)), 'UTF-8');
    }
}
