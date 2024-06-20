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
        /*    $this->template->comments = $post->related('comments')->order('created_at'); */
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
        $form->addText('vidprev', 'Video Preview (YouTube Embed URL):');

        $form->addSubmit('send', 'Save and Publish');
        $form->onSuccess[] = $this->modFormSucceeded(...);

        return $form;
    }

    private function modFormSucceeded($form, $data): void
    {
        $id = $this->getParameter('id');

        if (filesize($data->image) > 0) {
            if ($data->image->isOk()) {
                // Extract the file extension
                $extension = pathinfo($data->image->getSanitizedName(), PATHINFO_EXTENSION);

                // Define the new file name as "thumbnail" with the original extension
                $newFileName = 'thumbnail.' . $extension;

                // Define the upload path
                $uploadPath = 'upload/mods/' . $id . '/' . $newFileName;

                // Move the uploaded file to the new location with the new file name
                $data->image->move($uploadPath);

                // Update the image path in the $data array
                $data['image'] = $uploadPath;
            } else {
                $this->flashMessage('File was not added', 'failed');
            }
        }

        if ($id) {
            $mod = $this->facade->editMod($id, (array) $data);
        } else {
            $mod = $this->facade->insertMod((array) $data);
        }

        $this->flashMessage('Mod has been published successfully.', 'success');
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
}
