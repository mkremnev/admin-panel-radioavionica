<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangePassword;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     */
    public string $id = '';
    /**
     * @Assert\NotBlank()
     */
    public string $current = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=10,
     *     minMessage="Длина пароля не должна быть меньше {{ limit }} символов.",
     *     allowEmptyString=true
     * )
     */
    public string $new = '';
}
