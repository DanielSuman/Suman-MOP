<?php

namespace App\Model;

use Nette;

final class GameFacade
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    public function insertGame($data)
    {
        $game = $this->database
            ->table('games')
            ->insert($data);

        return $game;
    }
    public function editGame($gameId, $data)
    {
        $game = $this->database
            ->table('games')
            ->get($gameId);
        $game->update($data);
        
        return $game;
    }

    public function getPublishedGames()
    {
        return $this->database
            ->table('games')
            ->where('created_at < ', new \DateTime)
            ->order('created_at DESC');
    }

    public function getGameById(int $id)
    {
        $game = $this->database
            ->table('games')
            ->get($id);
        return $game;
    }

}