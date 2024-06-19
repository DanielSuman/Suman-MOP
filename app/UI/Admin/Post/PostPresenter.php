<?php

namespace App\UI\Admin\Post;

use Nette;
use App\Model\PostFacade;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

final class PostPresenter extends Nette\Application\UI\Presenter
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

		$grid->addAction('Post:show', 'View');
        $grid->addAction('Post:edit', 'Edit');
        $grid->addAction('delete', 'Delete', 'delete!')
            ->setClass('btn btn-xs btn-danger ajax');

		return $grid;
	}

    public function renderShow(int $id): void
    {
        $post = $this->facade
            ->getPostById($id);
        if (!$post) {
            $this->error('Post not found');
        }
        $this->template->post = $post;
        $this->template->comments = $post->related('comments')->order('created_at');
    }

    /* Deletion of Posts */

    public function handleDelete(int $id): void
    {
        $this->facade->deletePost($id);
        $this->flashMessage('Mod was deleted.', 'success');
        $this->redirect('this');
    }

        protected function createComponentPostForm(): Form
    {
        $form = new Form;

        $form->addText('title', 'Titulek:')
            ->setRequired();
        $form->addTextArea('content', 'Obsah:')
            ->setRequired();
        $form->addUpload('image', 'Soubor')
            ->setRequired()
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF');

        // Assuming $userId is the ID of the current user
        $userId = $this->getUser()->getId(); // Adjust this based on how you retrieve user ID

        // Add a hidden field to store user_id
        $form->addHidden('user_id')->setDefaultValue($userId);

        $form->addSubmit('send', 'Uložit a publikovat');
        $form->onSuccess[] = $this->postFormSucceeded(...);

        return $form;
    }

    private function postFormSucceeded($form, $data): void
    {
        $id = $this->getParameter('id');

        if (filesize($data->image) > 0) {
            if ($data->image->isOk()) {
                // Extract the file extension
                $extension = pathinfo($data->image->getSanitizedName(), PATHINFO_EXTENSION);
                
                // Define the new file name as "thumbnail" with the original extension
                $newFileName = 'thumbnail.' . $extension;
        
                // Define the upload path
                $uploadPath = 'upload/posts/' . $id . '/' . $newFileName;
        
                // Move the uploaded file to the new location with the new file name
                $data->image->move($uploadPath);
        
                // Update the image path in the $data array
                $data['image'] = $uploadPath;
            } else {
                $this->flashMessage('File was not added', 'failed');
            }
        }        

        if ($id) {
            $post = $this->facade->editPost($id, (array) $data);
        } else {
            $post = $this->facade->insertPost((array) $data);
        }

        $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
        $this->redirect('Post:show', $post->id);
    }

    public function renderEdit(int $id): void
    {
        $post = $this->facade->getPostById($id);

        if (!$post) {
            $this->error('Post not found');
        }

        $this->getComponent('postForm')
            ->setDefaults($post->toArray());
    }


    /* Comments */

    protected function createComponentCommentForm(): Form
    {
        $form = new Form; // means Nette\Application\UI\Form

        $form->addText('name', 'Name:')
            ->setRequired();

        $form->addEmail('email', 'E-mail:');

        $form->addTextArea('content', 'Comment:')
            ->setRequired();

        $form->addSubmit('send', 'Publikovat komentář');

        $form->onSuccess[] = $this->commentFormSucceeded(...);

        return $form;
    }

    private function commentFormSucceeded(\stdClass $data): void
    {
        $postId = $this->getParameter('id');

        $this->database->table('comments')->insert([
            'post_id' => $postId,
            'name' => $data->name,
            'email' => $data->email,
            'content' => $data->content,
        ]);

        $this->flashMessage('Děkuji za komentář', 'success');
        $this->redirect('this');
    }
}
