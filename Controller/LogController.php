<?php

declare(strict_types=1);

namespace Twenty5Carat\ApiLoggerBundle\Controller;

use Oro\Bundle\ApiBundle\Controller\RestApiController;
use Twenty5Carat\ApiLoggerBundle\Handler\LogHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LogController
{
    public function __construct(
        private readonly RestApiController $apiController,
        private readonly LogHandler $logHandler,
    ) {
    }

    public function itemAction(Request $request): Response
    {
        $this->logHandler->logRequest($request);
        $response = $this->apiController->itemAction($request);
        $this->logHandler->logResponse($response);

        return $response;
    }

    public function listAction(Request $request): Response
    {
        $this->logHandler->logRequest($request);
        $response = $this->apiController->listAction($request);
        $this->logHandler->logResponse($response);

        return $response;
    }

    public function subresourceAction(Request $request): Response
    {
        $this->logHandler->logRequest($request);
        $response = $this->apiController->subresourceAction($request);
        $this->logHandler->logResponse($response);

        return $response;
    }

    public function relationshipAction(Request $request): Response
    {
        $this->logHandler->logRequest($request);
        $response = $this->apiController->relationshipAction($request);
        $this->logHandler->logResponse($response);

        return $response;
    }

    public function itemWithoutIdAction(Request $request): Response
    {
        $this->logHandler->logRequest($request);
        $response = $this->apiController->itemWithoutIdAction($request);
        $this->logHandler->logResponse($response);

        return $response;
    }
}
