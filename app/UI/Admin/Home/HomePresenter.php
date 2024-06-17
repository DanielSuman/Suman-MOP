<?php

declare(strict_types=1);

namespace App\UI\Admin\Home;

use Nette;
use App\Model\PostFacade;
use Ublaboo\DataGrid\DataGrid;


final class HomePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private PostFacade $facade,
    ) {
    }

	public function createComponentSimpleGrid($name)
	{
		$grid = new Datagrid($this, $name);

		$grid->setDataSource($this->facade->getAll());
		$grid->addColumnNumber('id', 'Id')->setSortable();
		$grid->addColumnText('title', 'Title')->setSortable();
		$grid->addColumnText('content', 'Content')->setSortable();
		$grid->addColumnText('image', 'Image')->setSortable();
		$grid->addColumnDateTime('created_at', 'Created at')->setSortable();

		return $grid;
	}

}
