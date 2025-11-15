<?php

namespace App\Services;

use App\Models\Product;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;


class IndexService
{
    /**
     * Индексация товаров
     *
     * @return void
     * @throws \Elastic\Elasticsearch\Exception\AuthenticationException
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function index()
    {
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
                    'name_prefix' => $product->name,
                    'description' => $product->description,
                    'price'       => $product->price,
                    'image'    => $product->image
                ]
            ]);
        }
    }


}
