<?php

namespace App\UI\Game;

use Nette;
use App\Model\GameFacade;
use Nette\Application\UI\Form;

final class GamePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private GameFacade $facade,
    ) {
    }

    public function renderDefault(): void
    {
        $games = $this->facade
            ->getPublishedGames()
            ->limit(5);

        bdump($games);

        $this->template->games = $games;
    }

    public function renderShow(int $id): void
    {
        $game = $this->facade
            ->getGameById($id);
        if (!$game) {
            $this->error('Post not found');
        }

        $this->template->game = $game;
    }
}
