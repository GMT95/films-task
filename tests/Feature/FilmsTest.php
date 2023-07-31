<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\Genre;
use Database\Seeders\GenreSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FilmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_films_list(): void
    {
        $this->seed();

        $response = $this->json('GET', route('films.index'));

        $response->assertJsonStructure([
            'data' => [
                'films' => [
                    '*' => [
                        'id',
                        'slug',
                    ],
                ],
            ],
            'success',
        ]);

        $response->assertOk();
    }

    public function test_get_single_film(): void
    {
        $this->seed();

        $filmSlug = Film::query()->first()->slug;

        $response = $this->json('GET', route('films.show', ['film' => $filmSlug]));

        $response->assertJsonStructure([
            'data' => [
                'film' => ['id', 'slug'],
            ],
            'success',
        ]);

        $response->assertOk();
    }

    public function test_store_film(): void
    {
        $this->seed(GenreSeeder::class);

        Storage::fake('public');

        $genreIds = Genre::query()
                        ->inRandomOrder()
                        ->select('id')
                        ->limit(2)
                        ->get()
                        ->pluck('id')
                        ->toArray();

        $requestData = [
            'name' => fake()->name(),
            'description' => fake()->realText(100),
            'release_date' => fake()->date(),
            'rating' => fake()->numberBetween(1, 5),
            'ticket_price' => 20,
            'country' => fake()->country(),
            'genres' => $genreIds,
            'photo' => UploadedFile::fake()->image('poster.jpg')
        ];

        $response = $this->postJson(route('films.store'), $requestData);

        /* Assert file exists */
        $fileName = str_replace("/storage", "" , $response->json()['data']['photo']);
        Storage::disk('public')->assertExists($fileName);


        $response->assertCreated();
    }

    public function test_update_film(): void
    {
        $this->seed();

        Storage::fake('public');

        $filmSlug = Film::query()->inRandomOrder()->first()->slug;

        $genreIds = Genre::query()
                        ->inRandomOrder()
                        ->select('id')
                        ->limit(3)
                        ->get()
                        ->pluck('id')
                        ->toArray();

        $updatedName = fake()->unique()->name();

        $requestUpdateData = [
            'name' => $updatedName,
            'genres' => $genreIds,
            'photo' => UploadedFile::fake()->image('poster_new.jpg')
        ];

        $response = $this->patchJson(route('films.update', ['film' => $filmSlug]), $requestUpdateData);

        /* Assert file exists */
        $fileName = str_replace("/storage", "" , $response->json()['data']['photo']);
        Storage::disk('public')->assertExists($fileName);

        $response->assertOk();
    }

    public function test_soft_delete_film(): void
    {
        $this->seed();

        $filmSlug = Film::query()->first()->slug;

        $response = $this->deleteJson(route('films.destroy', ['film' => $filmSlug]));

        /* Assert Film is soft deleted */
        $this->assertSoftDeleted('films', [
            'slug' => $filmSlug
        ]);

        $response->assertOk();
    }

}
