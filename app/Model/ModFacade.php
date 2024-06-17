<?php

namespace App\Model;

use Nette;

final class ModFacade
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    public function insertMod($data)
    {
        $mod = $this->database
            ->table('mods')
            ->insert($data);

        return $mod;
    }
    public function editMod($modId, $data)
    {
        $mod = $this->database
            ->table('mods')
            ->get($modId);
        $mod->update($data);
        return $mod;
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

    public function getAll()
    {
        return $this->database->table('mods')->fetchAll();
    }
}
