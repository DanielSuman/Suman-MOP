<?php

namespace App\UI\Front\Mod;

use Nette;
use App\Model\ModFacade;

final class ModPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private ModFacade $facade,
    ) {
    }

    public function renderDefault(int $page = 1): void
    {

        // Zjistíme si celkový počet publikovaných článků
		$modsCount = $this->facade->getPublishedModsByCount();

		// Vyrobíme si instanci Paginatoru a nastavíme jej
		$paginator = new Nette\Utils\Paginator;
		$paginator->setItemCount($modsCount); // celkový počet článků
		$paginator->setItemsPerPage(5); // počet položek na stránce
		$paginator->setPage($page); // číslo aktuální stránky

		// Z databáze si vytáhneme omezenou množinu článků podle výpočtu Paginatoru
		$mods = $this->facade->getPublishedMods($paginator->getLength(), $paginator->getOffset());

		// kterou předáme do šablony
		$this->template->mods = $mods;
		// a také samotný Paginator pro zobrazení možností stránkování
		$this->template->paginator = $paginator;

    }
/*
    public function renderDefault(): void
    {
        $mods = $this->facade
            ->getPublishedMods()
            ->limit(5);

        bdump($mods);

        $this->template->mods = $mods;
    } */

    public function renderShow(int $id): void
    {
        $mod = $this->facade
            ->getModById($id);
        if (!$mod) {
            $this->error('Mod not found');
        }
        $this->template->mod = $mod;
    /*    $this->template->comments = $post->related('comments')->order('created_at'); */
    }

}
