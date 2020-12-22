<?php

/*
 * Message Client Bundle
 */

declare(strict_types=1);

namespace StocksApiBundles\MessageClient\Protocol;

interface SubscriptionInterface extends TopicInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param [type] $id
     *
     * @return SubscriptionInterface [description]
     */
    public function set($id = null): SubscriptionInterface;

    /**
     * @return string [description]
     */
    public function getCallback(): string;

    /**
     * @param string $url
     *
     * @return SubscriptionInterface
     */
    public function setCallback(string $url): SubscriptionInterface;
}
