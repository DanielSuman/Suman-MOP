<?php

namespace App\Model;

use Nette;

final class ModFacade
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    public function getPublishedMods()
    {
        return $this->database
            ->table('mods')
            ->where('created_at < ', new \DateTime)
            ->order('created_at DESC');
    }

    public function getModById(int $id)
    {
        $mod = $this->database
            ->table('mods')
            ->get($id);
        return $mod;
    }

}