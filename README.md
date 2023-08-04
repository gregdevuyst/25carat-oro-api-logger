![](https://github.com/25carat/25carat-oro-api-logger/workflows/.github/workflows/grumphp.yml/badge.svg)

# Api Logger for Oro Commerce

This bundle will add logging of all api requests and responses. 
This is useful for monitoring applications or services which consume the Oro Rest API.

## Installation

    composer require 25carat/oro-api-logger

## Configuration

Add the minimum log level configuration to the `parameters.yml.dist` file of your project. 
If this parameter is missing, it will cause errors in the service container.

    :::yaml
    parameters:
      twenty5carat.api_logger.level: error

## Logging

### Channel

A separate channel `api_logger` has been created to log the api messages.

The messages will be logged in a separate file `api-logger-[environment].log`

### Log Levels

The amount of information in the log messages depends on the configured log level.

Server errors are logged as `critical` messages.

Client errors are logged as `error` messages.

Request and response headers are logged as `info` messages.

Request and response bodies are logged as `debug` messages.
