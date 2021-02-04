<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangeEmail\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     */
    public string $id = '';
    /**
     * @Assert\Email()
     *@Assert\NotBlank()
     */
    public string $email = '';
}
