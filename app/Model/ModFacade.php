<?php

namespace App\Model;

use Nette;

final class ModFacade
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    public function getPublishedMods(int $limit, int $offset): Nette\Database\ResultSet
    {
        return $this->database->query(
            '
        SELECT * FROM mods
        WHERE created_at < ?
        ORDER BY created_at DESC
        LIMIT ?
        OFFSET ?',
            new \DateTime,
            $limit,
            $offset,
        );

    }

    public function getPublishedModsByCount(): int
    {
        return $this->database->fetchField('SELECT COUNT(*) FROM mods WHERE created_at < ?', new \DateTime);
    }

    public function getModById(int $id)
    {
        $mod = $this->database
            ->table('mods')
            ->get($id);
        return $mod;
    }

}