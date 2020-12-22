<?php

/*
 * Message Client Bundle
 */

declare(strict_types=1);

namespace StocksApiBundles\MessageClient\Protocol;

interface PacketInterface extends TopicInterface
{
    /**
     * @return mixed
     */
    public function getMessage();

    /**
     * @param mixed $data
     *
     * @return PacketInterface
     */
    public function setMessage($data): PacketInterface;

    /**
     * @return mixed
     */
    public function getOriginalMessage();

    /**
     * @param $message
     *
     * @return PacketInterface
     */
    public function setOriginalMessage($message): PacketInterface;
}
