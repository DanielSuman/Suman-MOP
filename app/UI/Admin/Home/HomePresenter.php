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

}
