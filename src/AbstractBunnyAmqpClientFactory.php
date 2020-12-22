<?php

/*
 * Message Client Bundle
 */

declare(strict_types=1);

namespace StocksApiBundles\MessageClient;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractBunnyAmqpClientFactory implements LoggerAwareInterface
{
    use Psr\Log\LoggerAwareTrait;

    /**
     * @var array
     */
    protected $options;

    public function __construct(
        array $options,
        LoggerInterface $logger
    ) {
        $this->setLogger($logger);
        $this->options = $options;
    }

    protected function mungOptions(
        ?Credentials $credentials = null
    ) {
        $options = $this->options;

        if ($credentials) {
            $options = array_merge($options, $credentials->getCredentials());
        }

        return $options;
    }
}
