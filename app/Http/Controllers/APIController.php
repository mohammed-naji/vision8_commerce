<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class APIController extends Controller
{
    public function posts()
    {
        // $posts = Http::get('https://jsonplaceholder.typicode.com/posts')->json();
        // $posts = Http::withToken('fdskhjahgfdsgfkjehgnrfiegijagfkadsgjhfg')->post('https://jsonplaceholder.typicode.com/posts', [
        //     'title' => 'fff',
        //     'body' => 'ddd'
        // ]);

        // return view('site.posts_api', compact('posts'));
        return view('site.posts_api');
        // dd($posts);
    }
}
