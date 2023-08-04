<?php

declare(strict_types=1);

namespace Twenty5Carat\ApiLoggerBundle\Handler;

use Twenty5Carat\ApiLoggerBundle\Formatter\HttpMessageFormatter;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LogHandler
{
    public function __construct(
        private readonly HttpMessageFormatter $formatter,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function logRequest(Request $request): void
    {
        $this->logger->info(sprintf("Received api request:\n%s", $this->formatter->formatRequest($request)));
        $this->logger->debug(sprintf("Received api request with body:\n%s", $this->formatter->formatBody($request)));
    }

    public function logResponse(Response $response): void
    {
        if ($response->isServerError()) {
            $this->logger->critical(sprintf("Sending api response:\n%s", $this->formatter->formatResponse($response)));
            $this->logger->critical(
                sprintf("Sending api response with body:\n%s", $this->formatter->formatBody($response))
            );
            return;
        }
        if ($response->isClientError()) {
            $this->logger->error(sprintf("Sending api response:\n%s", $this->formatter->formatResponse($response)));
            $this->logger->error(
                sprintf("Sending api response with body:\n%s", $this->formatter->formatBody($response))
            );
            return;
        }
        $this->logger->info(sprintf("Sending api response:\n%s", $this->formatter->formatResponse($response)));
        $this->logger->debug(sprintf("Sending api response with body:\n%s", $this->formatter->formatBody($response)));
    }
}
