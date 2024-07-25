<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/' => [[['_route' => 'app_index_index', '_controller' => 'App\\Controller\\IndexController::index'], null, ['GET' => 0], null, false, false, null]],
        '/questionnaire' => [[['_route' => 'app_questionnaire_index', '_controller' => 'App\\Controller\\QuestionnaireController::index'], null, ['GET' => 0], null, true, false, null]],
        '/questionnaire/answer' => [[['_route' => 'app_questionnaire_answer', '_controller' => 'App\\Controller\\QuestionnaireController::answer'], null, ['POST' => 0], null, false, false, 1]],
        '/user' => [[['_route' => 'user', '_controller' => 'App\\Controller\\UserController::update'], null, ['PUT' => 0], null, false, false, 2]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [
            [['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    static function ($condition, $context, $request, $params) { // $checkCondition
        switch ($condition) {
            case 1: return ($context->getParameter('_functions')->get('service')("questionnaire_check_answer"))->check($request);
            case 2: return ($context->getParameter('_functions')->get('service')("user_check"))->check($request);
        }
    },
];
