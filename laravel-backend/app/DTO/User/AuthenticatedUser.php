<?php

declare(strict_types=1);

namespace App\DTO\User;

class AuthenticatedUser
{
    public string $username = '';

    public string $token = '';

    public array $roles = ['ROLE_CLIENT'];
}
