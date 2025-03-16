<?php

namespace App\Providers;

use App\Models\Contact;
use App\Observers\ElasticsearchObserver;
use App\Services\ElasticsearchService;
use App\Services\Files\FileInterface;
use App\Services\Files\StorageFile;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FileInterface::class, StorageFile::class);

        $this->app->singleton(ElasticsearchService::class, function ($app) {
            return new ElasticsearchService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $observer = app(ElasticsearchObserver::class);
    
        Contact::observe($observer);
    }
}
