<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class SearchController
{
    public function search(Request $request)
    {
        $client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();
        $query = $request->input('q');

        if ($query) {

            $response = $client->search([
                'index' => 'products',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query'  => $query,
                            'fields' => ['name^3', 'description'],
                            'fuzziness' => 'AUTO'
                        ]
                    ]
                ]
            ]);
            $products = collect($response['hits']['hits'])->pluck('_source');
        } else {
            $products = Product::take(20)->get();
        }

        return view('catalog', compact('products'));

    }
}
