<?php

namespace App\Services\RequestServices\Contracts;

use Symfony\Component\HttpFoundation\Request;

interface RequestCheckerContract
{
    public function check(Request $request): bool;
}