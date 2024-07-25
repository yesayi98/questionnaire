<?php

use App\Services\RequestServices\Contracts\RequestCheckerContract;
use Symfony\Bundle\FrameworkBundle\Routing\Attribute\AsRoutingConditionService;
use Symfony\Component\HttpFoundation\Request;

#[AsRoutingConditionService(alias: 'user_check')]
class UserRequestChecker implements RequestCheckerContract
{
    public function check(Request $request): bool
    {
        // TODO: Implement check() method.
    }
}