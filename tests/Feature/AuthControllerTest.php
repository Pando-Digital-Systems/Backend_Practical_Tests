<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase; // This will reset the database after each test

    /** @test */
    public function user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'User registered successfully']);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function user_can_login()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Attempt to login
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Assert the response status and content
        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
            ]);
    }


    /** @test */
    public function user_can_retrieve_profile()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->get('/api/user-profile');

        $response->assertStatus(200)
            ->assertViewIs('user-profile') // Ensure the correct view is returned
            ->assertSee($user->name); // Check if user's name is displayed
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user); // Authenticate the user

        $response = $this->post('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully']);

        // Check that tokens have been deleted
        $this->assertCount(0, $user->tokens);
    }
}
