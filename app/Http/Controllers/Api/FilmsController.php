<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Traits\ResponseWrapper;
use Illuminate\Http\Request;

class FilmsController extends Controller
{
    use ResponseWrapper;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        $film->load([
            'genres:name',
            'comments' => fn ($q) => $q->select('text', 'film_id', 'user_id', 'created_at')
                ->latest()
                ->limit(5),
            'comments.user:id,name'
        ]);

        return $this->responseOk(compact('film'), "Film data");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
