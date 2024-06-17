<?php

namespace App\UI\Admin\Mod;

use Nette;
use App\Model\ModFacade;
use Ublaboo\DataGrid\DataGrid;

final class ModPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private ModFacade $facade,
    ) {
    }

    public function createComponentSimpleGrid($name)
    {
        $grid = new Datagrid($this, $name);

        $grid->setDataSource($this->facade->getAll());
        $grid->addColumnNumber('id', 'Id')->setSortable();
        $grid->addColumnText('name', 'Mod Name')->setSortable();
        $grid->addColumnText('description', 'Mod Description')->setSortable();
        $grid->addColumnText('image', 'Mod Thumbnail')->setSortable();
        $grid->addColumnText('vidprev', 'Mod Preview Video')->setSortable();
        $grid->addColumnText('created_by', 'Mod Author')->setSortable();
        $grid->addColumnDateTime('created_at', 'Created at')->setSortable();

        /* $grid->addColumnAction('edit', 'ModEdit:edit', '$modId'); Nefungující odkaz na editaci... */ 

        return $grid;
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
