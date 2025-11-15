<?php

namespace App\Services;

use App\Services\DTO\SearchProductDTO;
use Illuminate\Http\Request;
use App\Models\Product;
use Elastic\Elasticsearch\ClientBuilder;

class SearchService
{
    /**
     * Поиск товаров по совпадениям в elasticSearch
     *
     * @param SearchProductDTO $dto
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\Collection
     * @throws \Elastic\Elasticsearch\Exception\AuthenticationException
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function searchProduct(SearchProductDTO $dto)
    {
        $client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();
        $query = mb_strtolower($dto->getQuery());

        if ($query) {

            $esBody = [
                'size' => 10,
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'match' => [
                                    'name_prefix' => [
                                        'query' => $query
                                    ]
                                ]
                            ],
                            [
                                'multi_match' => [
                                    'query' => $query,
                                    'fields' => ['name^3', 'description'],
                                    'fuzziness' => 'AUTO'
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $response = $client->search([
                'index' => 'products',
                'body' => $esBody
            ]);

            $products = collect($response['hits']['hits'])->pluck('_source')->values();

            if ($dto->wantsJson()) {
                return response()->json($products);
            }

            return $products;
        }

        $products = Product::take(20)->get();

        if ($dto->wantsJson()) {
            return response()->json($products);
        }

        return $products;
    }

}
