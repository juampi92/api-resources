<?php

namespace Juampi92\APIResources\Exceptions;

use Exception;

class WrongConfigurationException extends Exception
{
    public static function missingAPIName(): self
    {
        return new self('[APIResources] API Name was not specified for the current request. Use APIResource::setAPIName(name: \'\')');
    }

    public static function apiNotConfigured(string $apiName, string $key): self
    {
        return new self("[APIResources] Config for api.{$key}.{$apiName} is missing.");
    }
}
