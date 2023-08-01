<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\FilmStoreRequest;
use App\Http\Requests\FilmUpdateRequest;
use App\Models\Film;
use App\Traits\ResponseWrapper;
use App\Services\Interfaces\FilmsServiceInterface;

class FilmsController extends Controller
{
    use ResponseWrapper;

    public function __construct(protected FilmsServiceInterface $filmsService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filmsPaginated = $this->filmsService->index();

        return $this->responsePaginated($filmsPaginated, 'films', 'Films List Data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilmStoreRequest $request)
    {
        $film = $this->filmsService->store($request);

        return $this->responseCreated($film, "Film Added Successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        $film = $this->filmsService->show($film);

        return $this->responseOk(compact('film'), "Film data");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilmUpdateRequest $request, Film $film)
    {
        $film = $this->filmsService->update($request, $film);

        return $this->responseOk($film, "Film Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        $filmId = $this->filmsService->destroy($film);

        return $this->responseOk(['film_id' => $filmId], "Film deleted successfully");
    }

    /**
     * Add Comment to film.
     */
    public function addComment(AddCommentRequest $request, Film $film)
    {
        $comment = $this->filmsService->addComment($request, $film);

        return $this->responseOk(compact('comment'), "Comment added successfully");
    }
}
