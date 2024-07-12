<?php

namespace App\UI\Admin\Mod;

use Nette;
use App\Model\ModFacade;
use Ublaboo\DataGrid\DataGrid;
use Nette\Application\UI\Form;

final class ModPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private ModFacade $facade,
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
        $grid->addColumnText('name', 'Mod Name')->setSortable();
        $grid->addColumnText('description', 'Mod Description')->setSortable();
        $grid->addColumnText('image', 'Mod Thumbnail')->setSortable();
        $grid->addColumnText('vidprev', 'Mod Preview Video')->setSortable();
        $grid->addColumnText('user_id', 'Mod Author')->setSortable();
        $grid->addColumnText('mod_category', 'Mod Category')->setSortable();
        $grid->addColumnDateTime('created_at', 'Created at')->setSortable();

        $grid->addAction('Mod:show', 'View');
        $grid->addAction('Mod:edit', 'Edit');
        $grid->addAction('delete', 'Delete', 'delete!')
            ->setClass('btn btn-xs btn-danger ajax');

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
        $this->template->comments = $mod->related('comments')->order('created_at');
    }

    /* Deletion of Mods */

    public function handleDelete(int $id): void
    {
        $this->facade->deleteMod($id);
        $this->flashMessage('Mod was deleted.', 'success');
        $this->redirect('this');
    }

    /* Creation of Mods */

    protected function createComponentModForm(): Form
    {
        $form = new Form;

        $form->addText('name', 'Mod Name:')
            ->setRequired();

        $form->addTextArea('description', 'Mod Description:')
            ->setRequired();

        $form->addUpload('image', 'Mod Thumbnail')
            ->setRequired()
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF');
        
        $form->addText('mod_url', 'Mod Webpage (Steam URL):')
            ->setRequired();
            
        $form->addText('vidprev', 'Video Preview (YouTube Embed URL):');

        $form->addSubmit('send', 'Save and Publish');
        $form->onSuccess[] = $this->modFormSucceeded(...);

        return $form;
    }

    private function modFormSucceeded($form, $data): void
    {   
        $id = $this->getParameter('id');
        $uniqId = uniqid();
        if (filesize($data->image) > 0) {
            if ($data->image->isOk()) {
                // Extract the file extension
                $data->image->move('upload/mods/' . $uniqId . '/' . $data->image->getSanitizedName());
                $data['image'] = 'upload/mods/' . $uniqId . '/'. $data->image->getSanitizedName();
            } else {
                $this->flashMessage('File was not added', 'failed');
            }
        }
        if ($id) {
            $mod = $this->facade->editMod($id, (array) $data);
        } else {
            $mod = $this->facade->insertMod((array) $data);
        }

    //    $this->flashMessage('Mod has been published successfully.', 'success');
        $this->redirect('Mod:show', $mod->id);
    }

    public function renderEdit(int $id): void
    {
        $mod = $this->facade->getModById($id);

        if (!$mod) {
            $this->error('Mod not found');
        }

        $this->getComponent('modForm')
            ->setDefaults($mod->toArray());
    }

    /* Comments Section */

    protected function createComponentCommentForm(): Form
    {
        $form = new Form; // means Nette\Application\UI\Form

        // Get email from user identity (assuming it's available)
        $identity = $this->getUser()->getIdentity(); // Adjust this based on your application's authentication logic

        $form->addHidden('user_id', 'Id:')
            ->setRequired()
            ->setDefaultValue($identity ? $identity->id : '');

        $form->addHidden('nickname', 'Nickname:')
            ->setRequired()
            ->setDefaultValue($identity ? $identity->nickname : '');


        $form->addHidden('email', 'E-mail:')
            ->setRequired()
            ->setDefaultValue($identity ? $identity->email : ''); // Set default value from identity, if available

        $form->addTextArea('content', 'Comment:')
            ->setRequired();

        $form->addSubmit('send', 'Comment on this post');

        $form->onSuccess[] = $this->commentFormSucceeded(...);

        return $form;
    }

    private function commentFormSucceeded(\stdClass $data): void
    {
        try {
            $id = $this->getParameter('id');

            $this->cfacade->insertComment([
                'mod_id' => $id,
                'user_id' => $data->user_id,
                'name' => $data->nickname,
                'email' => $data->email,
                'content' => $data->content,
            ]);

            $this->flashMessage('Thank you for your comment.', 'success');
        } catch (\Exception $e) {
            $this->flashMessage('There was an error creating the comment: ' . $e->getMessage(), 'error');
        }

        $this->redirect('this');
    }

    /* Deletion of Comments */
    public function handleDeleteComment($commentId): void
    {
        // Get the current user (assuming you have some way to retrieve the logged-in user)
        $currentUser = $this->getUser();

        // Retrieve the comment from the database
        $comment = $this->cfacade->getCommentById($commentId);

        if (!$comment) {
            $this->flashMessage('Comment not found.', 'error');
        } else {
            // Check if the current user is the owner of the comment
            if ($currentUser->isLoggedIn() && ($currentUser->getId() === $comment->user_id)) {
                $this->cfacade->deleteComment($commentId);
                $this->flashMessage('Comment was deleted.', 'success');
            } elseif ($currentUser->isInRole('admin') || $currentUser->isInRole('moderator')) {
                // Check if the current user is an admin or moderator
                $this->cfacade->deleteComment($commentId);
                $this->flashMessage('Comment was deleted as admin/moderator.', 'success');
            } else {
                // Unauthorized deletion attempt
                $this->flashMessage('You are not authorized to delete this comment.', 'error');
            }
        }

        // Redirect back to the current page
        $this->redirect('this');
    }
}
