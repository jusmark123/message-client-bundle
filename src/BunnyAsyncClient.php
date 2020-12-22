<?php

/*
 * Message Client Bundle
 */

declare(strict_types=1);

namespace StocksApiBundles\MessageClient;

use Bunny\Async\Client;
use Evenement\EventEmitterInterface;
use Evenement\EventEmitterTrait;
use React\Promise;

class BunnyAsyncClient extends Client implements EventEmitterInterface
{
    use EventEmitterTrait;

    public function onDataAvaliable()
    {
        try {
            parent::onDataAvaliable();
        } catch (\Throwable $e) {
            $this->event->removeReadStream($this->getStream());
            $this->emitFuture('error', [$e]);
        }
    }

    /**
     * @return Promise\PromiseInterface
     */
    public function connect()
    {
        $deferred = new Promise\Deferred();

        $errBack = function (\Throwable $e) use ($deferred, &$errBack) {
            $this->removeListener('error', $errBack);
            $deferred->reject($e);
        };

        $this->on('error', $errBack);

        parent::connect()->then(
                function () use ($deferred) {
                    return $deferred->resolve($this);
                },
                function (\Throwable $e) use ($deferred) {
                    $deferred->reject($e);
                }
            )->always(function () use ($errBack) {
                $this->removeListener('event', $errback);
            });

        return $deferred->promise();
    }

    /**
     * @param int    $replyCode
     * @param string $replyText
     *
     * @return Promise\PromiseInterface
     */
    public function disconnect($replyCode = 0, $replyText = '')
    {
        return parent::disconnect(
                $replyCode,
                $replyText
            )->always(function () use ($replyCode, $replyText) {
                $this->emit('disconnect', [
                    $replyCode,
                    $replyText,
                    $this,
                ]);
            });
    }

    protected function emitFuture(
            string $event,
            array $args = []
        ) {
        $this->eventLoop->futureTick(function () use ($event, $args) {
            $this->emit($event, $args + [$this]);
        });
    }

    protected function read()
    {
        try {
            parent::read();
        } catch (ClientException $clientException) {
            $this->eventLoop->removeReadStream($this->getStream());
            $this->emitFuture('error', [$clientException]);
            $this->disconnect();
        }
    }

    protected function write()
    {
        try {
            parent::write();
        } catch (ClientException $clientException) {
            $this->eventLoop->removeWriteStream($this->getStream());
            $this->emitFuture('error', [$clientException]);
            $this->disconnect();
        }
    }
}
