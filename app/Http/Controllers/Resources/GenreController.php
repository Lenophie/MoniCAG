<?php

namespace App\Http\Controllers\Resources;

use App\Genre;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGenreRequest;
use App\Http\Requests\DeleteGenreRequest;
use App\Http\Requests\UpdateGenreRequest;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('client:see-genres')->only('index');
        $this->middleware('api.client:edit-genres')->except('index');
        $this->middleware('admin')->except('index');
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
     * @paramU  \App\Http\Requests\AddGenreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGenreRequest $request)
    {
        Genre::create([
            'name_fr' => htmlspecialchars(request('nameFr')),
            'name_en' => htmlspecialchars(request('nameEn')),
        ]);
        return response([], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGenreRequest  $request
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        $genre->update([
            'name_fr' => htmlspecialchars(request('nameFr')),
            'name_en' => htmlspecialchars(request('nameEn')),
        ]);
        return response([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\DeleteGenreRequest $request
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteGenreRequest $request, Genre $genre)
    {
        $genre->delete();
        return response([], 200);
    }
}
