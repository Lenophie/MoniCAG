<?php

namespace App\Http\Controllers\Resources;

use App\Genre;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGenreRequest;
use App\Http\Requests\DeleteGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        abort_unless(Gate::allows('viewAny', Genre::class), Response::HTTP_FORBIDDEN);
        $genres = Genre::all();
        return response($genres, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateGenreRequest $request
     * @return Response
     */
    public function store(CreateGenreRequest $request)
    {
        Genre::create([
            'name_fr' => htmlspecialchars(request('nameFr')),
            'name_en' => htmlspecialchars(request('nameEn')),
        ]);
        return response([], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGenreRequest $request
     * @param Genre $genre
     * @return Response
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        $genre->update([
            'name_fr' => htmlspecialchars(request('nameFr')),
            'name_en' => htmlspecialchars(request('nameEn')),
        ]);
        return response([], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteGenreRequest $request
     * @param Genre $genre
     * @return Response
     * @throws Exception
     */
    public function destroy(DeleteGenreRequest $request, Genre $genre)
    {
        $genre->delete();
        return response([], Response::HTTP_OK);
    }
}
