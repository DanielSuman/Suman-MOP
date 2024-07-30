<?php

namespace App\UI\Admin\User;

use Nette;
use App\Model\UserFacade;
use App\Services\MailManager;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

final class UserPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private UserFacade $facade,
        private MailManager $mailManager,
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

    public function createComponentSimpleGrid($name)
    {
        $grid = new Datagrid($this, $name);

        $grid->setDataSource($this->facade->getAll());
        $grid->addColumnNumber('id', 'Id')->setSortable();
        $grid->addColumnText('nickname', 'Nickname')->setSortable();
        $grid->addColumnText('firstname', 'Firstname')->setSortable();
        $grid->addColumnText('middlename', 'Middlename')->setSortable();
        $grid->addColumnText('lastname', 'Lastname')->setSortable();
        $grid->addColumnText('username', 'Username')->setSortable();
        $grid->addColumnText('email', 'Email')->setSortable();
        $grid->addColumnText('phone', 'Phone')->setSortable();
        $grid->addColumnText('country', 'Country')->setSortable();
        $grid->addColumnText('city', 'City')->setSortable();
        $grid->addColumnText('street', 'Street')->setSortable();
        $grid->addColumnText('zipcode', 'Zip Code')->setSortable();
        $grid->addColumnText('role', 'Authorization Level')->setSortable();


        $grid->addAction('User:show', 'View');
        $grid->addAction('User:edit', 'Edit');
        $grid->addAction('delete', 'Delete', 'delete!')
            ->setClass('btn btn-xs btn-danger ajax');

        return $grid;
    }

    public function renderShow(int $id): void
    {
        $user = $this->facade
            ->getUserById($id);
        if (!$user) {
            $this->error('User not found');
        }
        $this->template->userdata = $user;
    }

    /* Deletion of Users */

    public function handleDelete(int $id): void
    {
        $this->facade->deleteUser($id);
        $this->flashMessage('User was deleted.', 'success');
        $this->redirect('this');
    }

    protected function createComponentUserForm(): Form
    {
        $form = new Form;

        $form->addText('nickname', 'Nickname:')
            ->setRequired();
        $form->addText('firstname', 'Firstname:')
            ->setRequired();
        $form->addText('middlename', 'Middlename:');
        $form->addText('lastname', 'Lastname:')
            ->setRequired();
        $form->addText('username', 'Username:')
            ->setRequired();
        $form->addText('email', 'Email:')
            ->setRequired();
       # $form->addPassword('password', 'Password:');
        if ($this->getUser()->isLoggedIn() && empty($user['password'])) {
            // User has a password, so add the password field but do not make it required
            $form->addPassword('password', 'Password:');
        } else {
            // User does not have a password, so make the password field required
            $form->addPassword('password', 'Password:')
                 ->setRequired('Please enter a password.');
        }
        
        $form->addText('phone', 'Phone:')
            ->setRequired();
        $form->addText('country', 'Country:')
            ->setRequired();
        $form->addText('city', 'City:')
            ->setRequired();
        $form->addText('street', 'Street:')
            ->setRequired();
        $form->addText('zipcode', 'Zip Code:')
            ->setRequired();
        $form->addSelect('role', 'Role:', [
            'player' => 'Player',
            'moderator' => 'Moderator',
            'admin' => 'Admin',
        ])
            ->setPrompt('Select a role') // Optional: Adds a prompt option
            ->setRequired('Please select a role.');

        /*
        $form->addUpload('image', 'Soubor')
            ->setRequired()
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF'); */

        $form->addSubmit('send', 'Save User');
        $form->onSuccess[] = $this->userFormSucceeded(...);

        return $form;
    }

    private function userFormSucceeded($form, $data): void
    {
        $id = $this->getParameter('id');
    
        // Only hash and set the password if it was provided
        if (empty($data['password'])) {
            unset($data['password']); // Remove it if not set
        }
    
        if ($id) {
            $user = $this->facade->editUser($id, (array) $data);
        } else {
            $user = $this->facade->insertUser((array) $data);
        }
    
        $this->flashMessage('User was created successfully.', 'success');
        $this->redirect('User:show', $user->id);
    }
    

    public function renderEdit(int $id): void
    {
        $user = $this->facade->getUserById($id);

        if (!$user) {
            $this->error('User not found');
        }

        $this->getComponent('userForm')
            ->setDefaults($user->toArray());
    }
}
