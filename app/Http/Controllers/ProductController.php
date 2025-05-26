<?php

namespace App\Http\Controllers;

class ProductController
{
    public function getCatalog()
    {
        return view('catalog');
    }
}
