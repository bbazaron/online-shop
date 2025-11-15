<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\IndexService;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class IndexProducts extends Command
{
    private IndexService $indexService;
    public function __construct(IndexService $indexService)
    {
        parent::__construct();
        $this->indexService = $indexService;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:index-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index ElasticSearch products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Запуск индексации товаров...');

        $this->indexService->index();

        $this->info('Индексация завершена!');

    }
}
