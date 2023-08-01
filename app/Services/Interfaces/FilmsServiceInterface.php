<?php

namespace App\Services\Interfaces;

use App\Models\Film;
use Illuminate\Http\Request;

interface FilmsServiceInterface
{
    public function index();

    public function update(Request $request, Film $film);

    public function show(Film $film);

    public function store(Request $request);

    public function destroy(Film $film);

    public function addComment(Request $request, Film $film);
}
