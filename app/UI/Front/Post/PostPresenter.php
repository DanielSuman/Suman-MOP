<?php

namespace App\UI\Front\Post;

use Nette;
use App\Model\PostFacade;
use App\Model\CommentFacade;
use Nette\Application\UI\Form;

final class PostPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private PostFacade $facade,
        private CommentFacade $cfacade,
    ) {
    }
    public function renderDefault(int $page = 1): void
    {

        // Zjistíme si celkový počet publikovaných článků
        $postsCount = $this->facade->getPublicArticlesCount();

        // Vyrobíme si instanci Paginatoru a nastavíme jej
        $paginator = new Nette\Utils\Paginator;
        $paginator->setItemCount($postsCount); // celkový počet článků
        $paginator->setItemsPerPage(5); // počet položek na stránce
        $paginator->setPage($page); // číslo aktuální stránky

        // Z databáze si vytáhneme omezenou množinu článků podle výpočtu Paginatoru
        $posts = $this->facade->getPublicArticles($paginator->getLength(), $paginator->getOffset());

        // kterou předáme do šablony
        $this->template->posts = $posts;
        // a také samotný Paginator pro zobrazení možností stránkování
        $this->template->paginator = $paginator;
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

        #    $this->flashMessage('Thank you for your comment.', 'success');
        } catch (\Exception $e) {
        #    $this->flashMessage('There was an error creating the comment: ' . $e->getMessage(), 'error');
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
