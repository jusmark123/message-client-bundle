<?php

/*
 * Message Client Bundle
 */

declare(strict_types=1);

namespace StocksApiBundles\MessageClient;

use Psr\Log\LoggerInterface;
use React\EventLoop\LoopInterface;

class BunnyAmqpClientFactory extends AbstractBunnyAmqpClientFactory implements ClientFactory
{
    protected $loop;

    public function __construct(
        LoggerInterface $logger,
        LoopInterface $loop,
        array $options
    ) {
        parent::__construct($options, $logger);
        $this->loop = $loop;
    }
}
