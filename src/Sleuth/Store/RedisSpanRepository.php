<?php
/**
 * Created by PhpStorm.
 * User: ignasiluengo
 * Date: 13/3/17
 * Time: 11:28
 */

namespace Sleuth\Store;


use Predis\Client;
use Sleuth\Core\Span;

/**
 * Class RedisSpanRepository
 * @package Sleuth\Store
 */
class RedisSpanRepository implements SpanRepository
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function save(Span $span)
    {
        $key = sprintf("span:%s", $span->getSpanId());
        $this->client->hmset($key, $span->toArray());
    }

    public function delete(Span $span)
    {
        // TODO: Implement delete() method.
    }

    public function deleteTrace(Span $span)
    {
        // TODO: Implement deleteTrace() method.
    }

    public function findAllChildren(Span $span)
    {
        // TODO: Implement findAllChildren() method.
    }

    public function findAllChildrenRecursively(Span $span)
    {
        // TODO: Implement findAllChildrenRecursively() method.
    }
}