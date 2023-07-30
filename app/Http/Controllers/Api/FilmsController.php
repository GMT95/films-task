<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\FilmStoreRequest;
use App\Http\Requests\FilmUpdateRequest;
use App\Models\Comment;
use App\Models\Film;
use App\Traits\ImageUpload;
use App\Traits\ResponseWrapper;
use Illuminate\Http\Request;

class FilmsController extends Controller
{
    use ResponseWrapper, ImageUpload;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filmsPaginated = Film::query()
            ->with(['genres' => fn ($q) => $q->select('name')])
            ->paginate(1);

        return $this->responsePaginated($filmsPaginated, 'films', 'Films List Data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilmStoreRequest $request)
    {
        $uploadedImgPath = "/storage/" . $this->saveImage($request->photo);

        $filmData = $request->except('genres');

        $genreIds = $request->get('genres');

        $film = Film::create([...$filmData, 'photo' => $uploadedImgPath]);

        $film->genres()->sync($genreIds);

        return $this->responseCreated($film, "Film Added Successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        $film->load([
            'genres:name',
            'comments' => fn ($q) => $q->select('id', 'text', 'film_id', 'user_id', 'created_at')
                ->latest()
                ->limit(5),
            'comments.user:id,name'
        ]);

        return $this->responseOk(compact('film'), "Film data");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilmUpdateRequest $request, Film $film)
    {
        $validatedData = $request->validated();

        if($request->has('photo')) {
            $uploadedImgPath = "/storage/" . $this->saveImage($request->photo);

            $validatedData['photo'] = $uploadedImgPath;
        }

        if($request->has('genres')) {
            $genreIds = $request->get('genres');

            $film->genres()->sync($genreIds);
        }

        $film->update([...$validatedData]);

        return $this->responseOk($film, "Film Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        $film->delete();

        return $this->responseOk(['film_id' => $film->id], "Film deleted successfully");
    }

    /**
     * Add Comment to film.
     */
    public function addComment(AddCommentRequest $request, Film $film)
    {
        $userId = auth()->user()->id;

        $comment = Comment::create([
            "film_id" => $film->id,
            "user_id" => $userId,
            "text" => $request->get("text")
        ]);

        $comment->load("user:id,name");

        return $this->responseOk(compact('comment'), "Comment added successfully");
    }
}
