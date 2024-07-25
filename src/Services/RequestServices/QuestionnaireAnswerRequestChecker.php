<?php

use App\Services\RequestServices\Contracts\RequestCheckerContract;
use Symfony\Bundle\FrameworkBundle\Routing\Attribute\AsRoutingConditionService;
use Symfony\Component\HttpFoundation\Request;

#[AsRoutingConditionService(alias: 'answer_check')]
class QuestionnaireAnswerRequestChecker implements RequestCheckerContract
{
    public function check(Request $request): bool
    {
        // TODO: Implement check() method.
    }
}