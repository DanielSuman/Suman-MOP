<?php

declare(strict_types=1);

namespace App\UI\Admin\Home;

use Nette;
use App\Model\PostFacade;


final class HomePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private PostFacade $facade,
    ) {
    }

    public function renderDefault(int $page = 1): void
    {

        // Zjistíme si celkový počet publikovaných článků
		$postsCount = $this->facade->getPublicArticlesCount();

		// Vyrobíme si instanci Paginatoru a nastavíme jej
		$paginator = new Nette\Utils\Paginator;
		$paginator->setItemCount($postsCount); // celkový počet článků
		$paginator->setItemsPerPage(5); // počet položek na stránce
		$paginator->setPage($page); // číslo aktuální stránky

		// Z databáze si vytáhneme omezenou množinu článků podle výpočtu Paginatoru
		$posts = $this->facade->getPublicArticles($paginator->getLength(), $paginator->getOffset());

		// kterou předáme do šablony
		$this->template->posts = $posts;
		// a také samotný Paginator pro zobrazení možností stránkování
		$this->template->paginator = $paginator;

    }
}
