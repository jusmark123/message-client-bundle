<?php

/*
 * Message Client Bundle
 */

declare(strict_types=1);

namespace StocksApiBundles\MessageClient\Protocol;

interface Topic extends \JsonSerializable
{
    /**
     * @return string
     */
    public function getTopic(): string;

    /**
     * @param string $topic
     *
     * @return Topic
     */
    public function setTopic(string $topic): TopicInterface;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @param array $headers
     *
     * @return Topic
     */
    public function setHeaders(array $headers): TopicInterface;

    /**
     * @return bool
     */
    public function hasHeader(): bool;

    /**
     * @param string $name
     *
     * @return [type]
     */
    public function getHeader(string $name): ?string;

    /**
     * @param string $name
     * @param string $value
     *
     * @return Topic
     */
    public function addHeader(string $name, string $value): TopicInterface;

    /**
     * @param string $name
     *
     * @return Topic
     */
    public function removeHeader(string $name): TopicInterface;
}
