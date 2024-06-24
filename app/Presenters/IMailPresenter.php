<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Services\MailManager;


final class IMailPresenter extends Nette\Application\UI\Presenter
{
    private MailManager $mailManager;

    public function __construct(MailManager $mailManager)
    {
    
        $this->mailManager = $mailManager;

    }

    public function actionDefault() {
        $this->mailManager->sendNewsLetter([
            'daniel.suman@student.ossp.cz'
        ]);
    }
}