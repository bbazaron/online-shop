<?php

namespace Services\Logger;

interface LoggerInterface
{
    public function error(\Throwable $exception);
}