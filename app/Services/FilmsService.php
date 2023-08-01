<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Film;
use App\Services\Interfaces\FilmsServiceInterface;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FilmsService implements FilmsServiceInterface
{
    use ImageUpload;

    public function index(): LengthAwarePaginator
    {
        $filmsPaginated = Film::query()
            ->with(['genres' => fn ($q) => $q->select('name')])
            ->paginate(1);

        return $filmsPaginated;
    }

    public function store(Request $request): Film
    {
        $uploadedImgPath = "/storage/" . $this->saveImage($request->photo);

        $filmData = $request->except('genres');

        $genreIds = $request->get('genres');

        $film = Film::create([...$filmData, 'photo' => $uploadedImgPath]);

        $film->genres()->sync($genreIds);

        return $film;
    }

    public function show(Film $film): Film
    {
        $film->load([
            'genres:name',
            'comments' => fn ($q) => $q->select('id', 'text', 'film_id', 'user_id', 'created_at')
                ->latest()
                ->limit(5),
            'comments.user:id,name'
        ]);

        return $film;
    }

    public function update(Request $request, Film $film): Film
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

        return $film;
    }

    public function destroy(Film $film): string
    {
        $film->delete();

        return $film->id;
    }

    public function addComment(Request $request, Film $film): Comment
    {
        $userId = auth()->user()->id;

        $comment = Comment::create([
            "film_id" => $film->id,
            "user_id" => $userId,
            "text" => $request->get("text")
        ]);

        $comment->load("user:id,name");

        return $comment;
    }
}
