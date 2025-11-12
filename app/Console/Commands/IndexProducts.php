<?php

namespace App\Console\Commands;

use App\Models\Product;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class IndexProducts extends Command
{
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

        $client = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->build();

        $products = Product::all();

        foreach ($products as $product) {
            $client->index([
                'index' => 'products',
                'id'    => $product->id,
                'body'  => [
                    'id'          => $product->id,
                    'name'        => $product->name,
                    'description' => $product->description,
                    'price'       => $product->price,
                    'image'    => $product->image
                ]
            ]);
        }

        $this->info('Индексация завершена!');
    }
}
