<?php

/*
 * Message Client Bundle
 */

declare(strict_types=1);

namespace StocksApiBundles\MessageClient\Protocol;

interface CredentialsInterface
{
    public function getCredentials(): array;
}
