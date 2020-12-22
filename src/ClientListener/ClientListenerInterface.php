<?php

/*
 * Message Client Bundle
 */

declare(strict_types=1);

namespace StocksApiBundles\MessageClient\ClientListener;

use StocksApiBundles\MessageClient\Protocol\Packet;

interface ClientListenerInterface
{
    const TAG = 'stocks-api-dev.message-client.client-listener';

    public function getSubscribedTopics();

    public function consume(Packet $packet, Channel $channel): Promise;
}
