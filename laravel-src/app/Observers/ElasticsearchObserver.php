<?php

namespace App\Observers;

use App\Services\ElasticsearchService;
use Illuminate\Database\Eloquent\Model;

class ElasticsearchObserver
{
    protected $elasticsearchService;

    public function __construct(ElasticsearchService $elasticsearchService)
    {
        $this->elasticsearchService = $elasticsearchService;
    }

    public function saved(Model $model)
    {
        $index = $this->getIndexName($model);
        $this->elasticsearchService->indexDocument($index, $model->id, $model->toArray());
    }

    public function deleted(Model $model)
    {
        $index = $this->getIndexName($model);
        $this->elasticsearchService->deleteDocument($index, $model->id);
    }

    private function getIndexName(Model $model)
    {
        return strtolower(class_basename($model)) . 's';
    }
}
