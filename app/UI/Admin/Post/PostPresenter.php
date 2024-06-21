<?php

namespace App\UI\Admin\Post;

use Nette;
use App\Model\PostFacade;
use App\Model\CommentFacade;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

final class PostPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private PostFacade $facade,
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
        $this->flashMessage('Post was deleted.', 'success');
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

        $form->addSubmit('send', 'Save and Publish');
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
                'post_id' => $id,
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
