<?php

namespace App\UI\Edit;

use Nette;
use App\Model\PostFacade;
use Nette\Application\UI\Form;

final class EditPresenter extends Nette\Application\UI\Presenter
{

    public function startup(): void
    {
        parent::startup();

        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }

    public function __construct(
        private PostFacade $facade,
    ) {
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

        $form->addSubmit('send', 'Uložit a publikovat');
        $form->onSuccess[] = $this->postFormSucceeded(...);

        return $form;
    }

    private function postFormSucceeded($form, $data): void
    {
        $postId = $this->getParameter('postId');

        if (filesize($data->image) > 0) {
            if ($data->image->isOk()) {
                $data->image->move('upload/' . 'posts/' . $postId . '/' . $data->image->getSanitizedName());
                $data['image'] = ('upload/' . 'posts/' . $postId . '/' . $data->image->getSanitizedName());
            } else {
                $this->flashMessage('File was not added', 'failed');
            }
        }

        if ($postId) {
            $post = $this->facade->editPost($postId, (array) $data);
        } else {
            $post = $this->facade->insertPost((array) $data);
        }

        $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
        $this->redirect('Post:show', $post->id);
    }

    public function renderEdit(int $postId): void
    {
        $post = $this->facade->getPostById($postId);

        if (!$post) {
            $this->error('Post not found');
        }

        $this->getComponent('postForm')
            ->setDefaults($post->toArray());
    }
}
