<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genresNames = [
            "Comedy", "Drama", "Romance", "Family",
            "Animation", "Action", "Fantasy",
            "Crime", "Adventure", "Mystery", "Thriller",
            "Documentary", "History", "War",
            "Sci-Fi", "Biography", "Horror", "Music"
        ];
        foreach ($genresNames as $key => $genresName) {
            Genre::create([
                'name' => $genresName,
            ]);
        }
    }
}
