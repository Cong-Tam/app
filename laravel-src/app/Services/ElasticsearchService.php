<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(config('services.elasticsearch.hosts'))
            ->build();
    }

    public function indexDocument($index, $id, $data)
    {
        return $this->client->index([
            'index' => $index,
            'id'    => $id,
            'body'  => $data,
        ]);
    }

    public function searchDocument($index, $query)
    {
        return $this->client->search([
            'index' => $index,
            'body'  => $query,
        ]);
    }

    public function deleteDocument($index, $id)
    {
        return $this->client->delete([
            'index' => $index,
            'id'    => $id,
        ]);
    }
}
