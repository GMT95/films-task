<?php

namespace Tests\Feature;

use App\Models\Film;
use Database\Seeders\GenreSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_index_page_redirects_to_films_page(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('films.list.page'));

        $response->assertStatus(302);
    }

    public function test_login_page(): void
    {
        $response = $this->get(route('login.page'));

        $response->assertSee("<login>", false)
            ->assertSee("</login>", false);

        $response->assertOk();
    }

    public function test_register_page(): void
    {
        $response = $this->get(route('register.page'));

        $response->assertSee("<register>", false)
            ->assertSee("</register>", false);

        $response->assertOk();
    }

    public function test_films_list_page(): void
    {
        $response = $this->get(route('films.list.page'));

        $response->assertSee("<films-list>", false)
            ->assertSee("</films-list>", false);

        $response->assertOk();
    }

    public function test_films_create_page(): void
    {
        $this->seed(GenreSeeder::class);

        $response = $this->get(route('films.create.page'));

        $response->assertSee("<create-film :genres=", false)
            ->assertSee("</create-film>", false);

        $response->assertOk();
    }

    public function test_film_single_page(): void
    {
        $this->seed();

        $filmSlug = Film::query()->first()->slug;

        $response = $this->get(route('films.view.page', ['slug' => $filmSlug]));

        $response->assertSee("<film :slug=", false)
            ->assertSee("</film>", false);

        $response->assertOk();
    }
}
