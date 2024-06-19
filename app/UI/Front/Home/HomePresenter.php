<?php

declare(strict_types=1);

namespace App\UI\Front\Home;

use Nette;
use App\Model\PostFacade;


final class HomePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private PostFacade $facade,
    ) {
    }


}
