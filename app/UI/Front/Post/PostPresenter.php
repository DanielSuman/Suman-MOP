<?php

namespace App\UI\Front\Post;

use Nette;
use App\Model\PostFacade;
use Nette\Application\UI\Form;

final class PostPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private PostFacade $facade,
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
