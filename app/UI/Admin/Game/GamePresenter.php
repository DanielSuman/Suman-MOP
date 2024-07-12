<?php

namespace App\UI\Admin\Game;

use Nette;
use App\Model\GameFacade;
use App\Model\CommentFacade;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

final class GamePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private GameFacade $facade,
        private CommentFacade $cfacade,
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
        $grid->addColumnText('image', 'Thumbnail')->setSortable();
        $grid->addColumnText('name', 'Title')->setSortable();
        $grid->addColumnText('trailer', 'Trailer')->setSortable();
        $grid->addColumnText('description', 'Description')->setSortable();


        $grid->addAction('Game:show', 'View');
        $grid->addAction('Game:edit', 'Edit');
        $grid->addAction('delete', 'Delete', 'delete!')
            ->setClass('btn btn-xs btn-danger ajax');

        return $grid;
    }

    public function renderDefault(): void
    {
        $games = $this->facade
            ->getPublishedGames()
            ->limit(5);

        bdump($games);

        $this->template->games = $games;
    }

    public function renderShow(int $id): void
    {
        $game = $this->facade
            ->getGameById($id);
        if (!$game) {
            $this->error('Post not found');
        }

        $this->template->game = $game;
    }
    /* Deletion of Games */

    public function handleDelete(int $id): void
    {
        $this->facade->deleteGame($id);
        $this->flashMessage('Game was deleted.', 'success');
        $this->redirect('this');
    }

    /* Creation of Games */

    protected function createComponentGameForm(): Form
    {
        $form = new Form;

        $form->addUpload('image', 'File')
            ->setRequired()
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF');

        $form->addText('name', 'Title:')
            ->setRequired();

        $form->addTextArea('description', 'Description:')
            ->setRequired();

        $form->addTextArea('trailer', 'Trailer:');

        $form->addTextArea('store_link', 'Store link:');

        $form->addSubmit('send', 'Save and Publish');
        $form->onSuccess[] = $this->gameFormSucceeded(...);

        return $form;
    }

    private function gameFormSucceeded($form, $data): void
    {
        $id = $this->getParameter('id');
        $uniqId = uniqid();
        if (filesize($data->image) > 0) {
            if ($data->image->isOk()) {
                // Extract the file extension
                $data->image->move('upload/games/' . $uniqId . '/' . $data->image->getSanitizedName());
                $data['image'] = 'upload/games/' . $uniqId . '/' . $data->image->getSanitizedName();
            } else {
                $this->flashMessage('File was not added', 'failed');
            }
        }
        if ($id) {
            $game = $this->facade->editGame($id, (array) $data);
        } else {
            $game = $this->facade->insertGame((array) $data);
        }

        //    $this->flashMessage('Mod has been published successfully.', 'success');
        $this->redirect('Game:show', $game->id);
    }

    public function renderEdit(int $id): void
    {
        $game = $this->facade->getGameById($id);

        if (!$game) {
            $this->error('Post not found');
        }

        $this->getComponent('gameForm')
            ->setDefaults($game->toArray());
    }
}
