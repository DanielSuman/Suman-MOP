<?php

declare(strict_types=1);

namespace App\UI\Home;

use Nette;
use App\Model\PostFacade;


final class HomePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private PostFacade $facade,
    ) {
    }

    public function renderDefault(): void
    {
        $posts = $this->facade
            ->getPublicArticles()
            ->limit(5);

        bdump($posts);

        $this->template->posts = $posts;
    }
}
