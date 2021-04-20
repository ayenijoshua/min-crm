<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Company;
use App\Providers\RouteServiceProvider;

class AuthenticateCompany extends TestCase
{
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/company-login');

        $response->assertStatus(200);
    }

    public function test_company_can_authenticate_using_the_login_screen()
    {
        $user = Company::factory()->create();

        $response = $this->post('/company-login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::COMPANY_DASHBOARD);
    }
}
