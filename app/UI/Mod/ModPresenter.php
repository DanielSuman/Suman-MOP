<?php

namespace App\UI\Mod;

use Nette;
use App\Model\ModFacade;
use Nette\Application\UI\Form;

final class ModPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private ModFacade $facade,
    ) {
    }

    public function renderDefault(): void
    {
        $mods = $this->facade
            ->getPublishedMods()
            ->limit(5);

        bdump($mods);

        $this->template->mods = $mods;
    }

    public function renderShow(int $id): void
    {
        $mod = $this->facade
            ->getModById($id);
        if (!$mod) {
            $this->error('Post not found');
        }

        $this->template->mod = $mod;
    }
}
