<?php

declare(strict_types=1);

namespace App\UI\Admin\Dashboard;

use Nette;


/**
 * Presenter for the dashboard view.
 * Ensures the user is logged in before access.
 */
final class DashboardPresenter extends Nette\Application\UI\Presenter
{
	protected function startup()
    {
        parent::startup();
        
        // Check if the user is logged in
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in'); // redirect to the login page
        }

        // Check if the user is an admin or a moderator
        if (!$this->getUser()->isInRole('admin') && !$this->getUser()->isInRole('moderator')) {
            $this->redirect(':Front:Home:'); // redirect to the front module
        }
    }
}
