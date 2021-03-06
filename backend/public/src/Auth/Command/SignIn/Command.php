<?php

declare(strict_types=1);

namespace App\Auth\Command\SignIn;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\Email()
     * @Assert\NotBlank
     */
    public string $email;
    /**
     * @Assert\NotBlank
     */
    public string $password;
}
