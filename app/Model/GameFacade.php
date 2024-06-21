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

    public function deleteGame($gameId)
    {
        $game = $this->database
            ->table('games')
            ->get($gameId);
    
        if ($game) {
            $game->delete();
            return true; // Return true to indicate successful deletion
        }
    
        return false; // Return false if the mod was not found
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

    public function getAll()
    {
        return $this->database->table('games')->fetchAll();
    }
}