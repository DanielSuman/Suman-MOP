<?php 

namespace App\Services;

use App\Interfaces\IMailManager;
use Latte\Runtime\Template;
use Nette\Mail\Mailer;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Mail\SmtpMailer;

class MailManager implements IMailManager 
{   
    private Mailer $mailer;
    public function __construct(Mailer $mailer)
    {
        /*
        $this->mailer = new SmtpMailer(
            host: '192.168.1.254',
            port: '25',
            username: '',
            password: '',
            //encryption: 'ssl',
        );*/
        $this->mailer = $mailer;
    }
    public function send(Message $email): void 
    {
        try {
            $this->mailer->send($email);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }
    public function sendNewsLetter(iterable $recipients): void 
    {
        $email = new Message();

        $email->setFrom('abc@abc.abc')
            ->setSubject('Nwesletter')
            ->setHtmlBody('<p>Content</p>');
            

        foreach ($recipients as $recipient) {
            $email->addTo($recipient);
            $this->send($email);
            //$email->clearAttachments();
        }
    }
}