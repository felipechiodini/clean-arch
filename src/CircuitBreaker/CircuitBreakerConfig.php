<?php

namespace App\CircuitBreaker;

use FelipeChiodini\CircuitBreaker\Contracts\CircutBreakConfig;

class CircuitBreakerConfig implements CircutBreakConfig
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'circuit_breaker';
    }

    /**
     * @inheritDoc
     */
    public function maxTries(): int
    {
        return 1;
    }

    /**
     * @inheritDoc
     */
    public function retryAfter(): int
    {
        return 10;
    }
}