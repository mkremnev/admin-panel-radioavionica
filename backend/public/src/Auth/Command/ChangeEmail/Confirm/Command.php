<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangeEmail\Confirm;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     */
    public string $token = '';
}
