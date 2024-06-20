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

    protected function startup()
    {
        parent::startup();

        // Check if the user is logged in
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in'); // redirect to the login page
        }

        // Check if the user is an admin
        if (!$this->getUser()->isInRole('admin')) {
            $this->redirect(':Front:Home:'); // redirect to the front module
        }
    }
    
}
