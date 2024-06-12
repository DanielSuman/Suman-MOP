<?php

namespace App\UI\Admin\ModEdit;

use Nette;
use App\Model\ModFacade;
use App\UI\Admin\Dashboard\RequireLoggedUser;
use Nette\Application\UI\Form;

final class ModEditPresenter extends Nette\Application\UI\Presenter
{

    use RequireLoggedUser;

    public function startup(): void
    {
        parent::startup();
        /* zde můžeme řešit uživatelskou roli */
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }

    public function __construct(
        private ModFacade $facade,
    ) {
    }

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
        $modId = $this->getParameter('modId');

        if (filesize($data->image) > 0) {
            if ($data->image->isOk()) {
                // Extract the file extension
                $extension = pathinfo($data->image->getSanitizedName(), PATHINFO_EXTENSION);

                // Define the new file name as "thumbnail" with the original extension
                $newFileName = 'thumbnail.' . $extension;

                // Define the upload path
                $uploadPath = 'upload/mods/' . $modId . '/' . $newFileName;

                // Move the uploaded file to the new location with the new file name
                $data->image->move($uploadPath);

                // Update the image path in the $data array
                $data['image'] = $uploadPath;
            } else {
                $this->flashMessage('File was not added', 'failed');
            }
        }

        if ($modId) {
            $mod = $this->facade->editMod($modId, (array) $data);
        } else {
            $mod = $this->facade->insertMod((array) $data);
        }

        $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
        $this->redirect('Mod:show', $mod->id);
    }

    public function renderEdit(int $modId): void
    {
        $mod = $this->facade->getModById($modId);

        if (!$mod) {
            $this->error('Mod not found');
        }

        $this->getComponent('modForm')
            ->setDefaults($mod->toArray());
    }
}
