<?php

namespace Tests\Back\User;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        if (! Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        if (! Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->post('/register', [
            'username' => 'TestUser',
            'email' => 'test@example.com',
            'password' => 'password++',
            'password_confirmation' => 'password++',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_registration_fails_with_invalid_password()
    {
        if (! Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->post('/register', [
            'username' => 'TestUser',
            'email' => 'test@example.com',
            'password' => 'weakpassword', // Intentionally invalid password
            'password_confirmation' => 'weakpassword',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $response->assertSessionHasErrors('password');
    }
}
