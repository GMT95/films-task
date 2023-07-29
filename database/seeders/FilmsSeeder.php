<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Film;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class FilmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filmsData = [
           [
            "name" => "Forrest Gump",
            "comment" => "A hilarious, large-spirited and tender epic.",
            "description" => "Forrest Gump, while not intelligent, has accidentally been present at many historic moments, but his true love, Jenny Curran, eludes him.",
            "genres" => ["Drama", "Romance"],
            "release_date" => "1994-07-06",
            "rating" => 4.1,
            "ticket_price" => 1850,
            "country" => "USA",
            "photo" => "https://m.media-amazon.com/images/M/MV5BNWIwODRlZTUtY2U3ZS00Yzg1LWJhNzYtMmZiYmEyNmU1NjMzXkEyXkFqcGdeQXVyMTQxNzMzNDI@._V1_SY1000_SX677_AL_.jpg"
           ],
           [
            "name" => "Jurassic Park",
            "comment" => "Even with sequels of debatable merit weighing it down, Spielberg's original 1993 movie can't be stopped.",
            "description" => "During a preview tour, a theme park suffers a major power breakdown that allows its cloned dinosaur exhibits to run amok.",
            "genres" => ["Adventure", "Sci-Fi", "Thriller"],
            "release_date" => "1993-06-11",
            "rating" => 3.6,
            "ticket_price" => 2500,
            "country" => "USA",
            "photo" => "https://m.media-amazon.com/images/M/MV5BMjM2MDgxMDg0Nl5BMl5BanBnXkFtZTgwNTM2OTM5NDE@._V1_SY1000_SX677_AL_.jpg"
           ],
           [
            "name" => "Iron Man 3",
            "comment" => "Beyond all the explosions and action set pieces and 3D wizardry, you can still hear a writer with a distinctive, entertaining voice.",
            "description" => "When Tony Stark's world is torn apart by a formidable terrorist called the Mandarin, he starts an odyssey of rebuilding and retribution.",
            "genres" => ["Adventure", "Sci-Fi", "Action"],
            "release_date" => "2013-05-03",
            "rating" => 4,
            "ticket_price" => 5000,
            "country" => "USA",
            "photo" => "https://m.media-amazon.com/images/M/MV5BMjE5MzcyNjk1M15BMl5BanBnXkFtZTcwMjQ4MjcxOQ@@._V1_SY1000_SX677_AL_.jpg"
           ],
        ];

        foreach($filmsData as $key => $filmData) {
            $data = Arr::except($filmData, ["comment", "genres"]);

            /* Store film data */
            $film = Film::create($data);

            /* Add genre id and film id to pivot table */
            $genreIds = Genre::query()
                        ->select('id')
                        ->whereIn('name', $filmData['genres'])
                        ->pluck('id');

            $film->genres()->sync($genreIds);

            /* Add comment to film */
            $commentText = $filmData['comment'];

            /* Attach comment to single random user */
            $userId = User::inRandomOrder()->first()->id;

            Comment::create([
                "text" => $commentText,
                "user_id" => $userId,
                "film_id" => $film->id
            ]);
        }
    }
}
