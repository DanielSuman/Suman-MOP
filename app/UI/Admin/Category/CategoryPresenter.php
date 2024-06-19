<?php

namespace App\UI\Admin\Category;

use Nette;
use App\Model\CategoryFacade;
use Ublaboo\DataGrid\DataGrid;
use Nette\Application\UI\Form;

final class CategoryPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private CategoryFacade $facade,
    ) {
    }

    public function createComponentSimpleGrid($name)
    {
        $grid = new Datagrid($this, $name);

        $grid->setDataSource($this->facade->getAll());
        $grid->addColumnNumber('id', 'Id')->setSortable();
        $grid->addColumnText('name', 'Category Name')->setSortable();
        $grid->addColumnText('description', 'Category Description')->setSortable();
        /*$grid->addColumnText('image', 'Image')->setSortable(); */
        $grid->addColumnDateTime('created_at', 'Created at')->setSortable();

        $grid->addAction('Category:show', 'View');
        $grid->addAction('Category:edit', 'Edit');
        $grid->addAction('delete', 'Delete', 'delete!')
            ->setClass('btn btn-xs btn-danger ajax');

        return $grid;
    }

    public function renderDefault(): void
    {
        $categories = $this->facade
            ->getAllCategories();
/*
        bdump($categories);
*/
        $this->template->categories = $categories;
    }

    public function renderShow(int $id): void
    {
        $category = $this->facade
            ->getCategoryById($id);
        if (!$category) {
            $this->error('Category not found');
        }

        $this->template->category = $category;
    }

    /* Deletion of Categories */

    public function handleDelete(int $id): void
    {
        $this->facade->deleteCategory($id);
        $this->flashMessage('Category was deleted.', 'success');
        $this->redirect('this');
    }

    /* Category Creation and Editation */

    protected function createComponentCategoryForm(): Form
    {
        $form = new Form;

        $form->addText('name', 'Category Name:')
            ->setRequired();
        $form->addTextArea('description', 'Category Description:')
            ->setRequired();
        /*    
        $form->addUpload('image', 'Category Thumbnail')
            ->setRequired()
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF');
        $form->addText('vidprev', 'Video Preview (YouTube Embed URL):'); */

        $form->addSubmit('send', 'Save and Publish');
        $form->onSuccess[] = $this->categoryFormSucceeded(...);

        return $form;
    }

    private function categoryFormSucceeded($form, $data): void
    {
        $id = $this->getParameter('id');
        /*
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
        } */

        if ($id) {
            $category = $this->facade->editCategory($id, (array) $data);
        } else {
            $category = $this->facade->insertCategory((array) $data);
        }

        $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
        $this->redirect('Category:show', $category->id);
    }

    public function renderEdit(int $id): void
    {
        $category = $this->facade->getCategoryById($id);

        if (!$category) {
            $this->error('Mod not found');
        }

        $this->getComponent('categoryForm')
            ->setDefaults($category->toArray());
    }
}
