<?php

namespace App\Interfaces;

use Nette\Mail\Message;

interface IMailManager {
    public function send(Message $mail): void;

    public function sendNewsletter(iterable $recipients): void;
}