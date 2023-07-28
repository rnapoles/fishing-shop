<?php

declare(strict_types=1);

namespace App\DTO;

class ResponseObject
{
    public bool $success = true;

    public string $message = '';

    public array $errors = [];

    public object|array|null $payload = null;
}
