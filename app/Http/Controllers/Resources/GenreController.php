<?php

namespace App\Http\Controllers\Resources;

use App\Genre;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddGenreRequest;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
        $this->middleware('admin')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genre::all();
        return response($genres, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AddGenreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddGenreRequest $request)
    {
        Genre::create([
            'name_fr' => htmlspecialchars(request('nameFr')),
            'name_en' => htmlspecialchars(request('nameEn')),
        ]);
        return response(null, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        //
    }
}
