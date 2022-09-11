<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $products_slider = Product::orderByDesc('id')->take(3)->get();
        $categories = Category::orderByDesc('id')->take(3)->get();

        return view('site.index', compact('products_slider', 'categories'));
    }
}
