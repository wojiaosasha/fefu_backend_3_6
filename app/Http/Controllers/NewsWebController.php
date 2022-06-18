<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Controllers\Controller;

class NewsWebController extends Controller
{
    /**
     *
     * @param  \IlluminateHttp\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listNews = News::query()->published()->paginate(5);
        return view('listNews', ['listNews' => $listNews]);
    }
    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return Responsable
     */
    public function show(string $slug)
    {
        $news = News::query()
            ->where('slug', $slug)->first();

        if ($news === null) {
            abort(404);
        }
        return view('news', ['news' => $news]);
    }
}
