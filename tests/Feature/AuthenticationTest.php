<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login_api()
    {
        $user = User::factory()->create();

        $response = $this->json('POST', route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->customAssertUserAuthenticated($response);

        $response->assertStatus(200);
    }

    public function test_users_can_register_using_the_register_api()
    {
        $response = $this->json('POST', route('register'), [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'Password',
            'password_confirmation' => 'Password'
        ]);

        $this->customAssertUserAuthenticated($response);

        $response->assertStatus(201);
    }

    public function test_users_cannot_login_with_incorrect_credentials()
    {
        $user = User::factory()->create();

        $response = $this->json('POST', route('login'), [
            'email' => $user->email,
            'password' => 'incorrect_password',
        ]);

        $this->assertGuest();

        $response->assertStatus(422);
    }

    public function test_users_cannot_register_with_invalid_payload()
    {
        $response = $this->json('POST', route('register'), [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'Password',
            'password_confirmation' => 'Password123'
        ]);

        $this->assertGuest();

        $response->assertStatus(422);
    }

    public function test_user_can_logout_from_web()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->json('GET', route('logout.web'));

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'auth-token',
        ]);

        $this->assertGuest('web');

        $response->assertRedirect(route('login.page'));
    }

    public function test_user_can_logout_from_api()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->json('GET', route('logout'));

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'auth-token',
        ]);

        $response->assertOk();
    }

    private function customAssertUserAuthenticated($response)
    {
        /* Assert Response is in required structure */
        $response->assertJsonStructure([
            'data' => [
                'user' => ['id'],
                'token'
            ],
        ]);

        /* Get User Id From Response */
        $userId = $response->json()['data']['user']['id'];

        /* Assert Token is generated in DB */
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $userId,
            'name' => 'auth-token',
        ]);

        $this->assertAuthenticated();
    }
}
