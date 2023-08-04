<?php

declare(strict_types=1);

namespace Twenty5Carat\ApiLoggerBundle\Formatter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Used \Http\Message\Formatter\FullHttpMessageFormatter as reference for implementation
 */
final class HttpMessageFormatter
{
    private string $binaryDetectionRegex = '/([\x00-\x09\x0C\x0E-\x1F\x7F])/';
    private array $sensitiveHeaders = ['authorization'];

    public function formatRequest(Request $request): string
    {
        $message = sprintf(
            "%s %s %s\n",
            $request->getMethod(),
            $request->getRequestUri(),
            $request->getProtocolVersion()
        );

        foreach ($request->headers as $name => $values) {
            if (in_array($name, $this->sensitiveHeaders)) {
                $values = ['xxxxxxx'];
            }
            $message .= $name.': '.implode(', ', $values)."\n";
        }

        return $message;
    }

    public function formatResponse(Response $response): string
    {
        $message = sprintf(
            "HTTP/%s %s %s\n",
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            (Response::$statusTexts[$response->getStatusCode()] ?? 'Unknown Status')
        );

        foreach ($response->headers as $name => $values) {
            $message .= $name.': '.implode(', ', $values)."\n";
        }

        return $message;
    }

    public function formatBody(Request|Response $message): string
    {
        $data = $message->getContent();

        if (preg_match($this->binaryDetectionRegex, $data)) {
            return '[binary stream omitted]';
        }

        $dataArray = json_decode($data, true);
        $type = $dataArray['data']['type'] ?? null;
        if ($type === 'files' && isset($dataArray['data']['attributes']['content'])) {
            $dataArray['data']['attributes']['content'] = '[file content omitted]';

            return json_encode($dataArray);
        }

        return json_encode(json_decode($data)); // removes white spacing from json data
    }
}
