<?php

declare(strict_types=1);

namespace JeroenG\Explorer\Infrastructure\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\ClientInterface;
use GuzzleHttp\Handler\MockHandler;

final class ElasticClientFactory
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function client(): ClientInterface
    {
        return $this->client;
    }

    public static function fake(FakeResponse $response): ElasticClientFactory
    {
        $handler = new MockHandler($response->toArray());
        $builder = ClientBuilder::create();
        $builder->setHosts(['testhost']);
        // $builder->setHandler($handler);
        return new self($builder->build());
    }
}
