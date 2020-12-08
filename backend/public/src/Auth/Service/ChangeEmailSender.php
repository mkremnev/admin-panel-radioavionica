<?php

declare(strict_types=1);

namespace App\Auth\Service;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;

interface ChangeEmailSender
{
    public function send(Email $email, Token $token): void;
}
