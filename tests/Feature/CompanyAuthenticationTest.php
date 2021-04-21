<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Company;
use App\Providers\RouteServiceProvider;

class AuthenticateCompany extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get(route('company.login'));

        $response->assertStatus(200);
    }

    public function test_company_can_authenticate_using_the_login_screen()
    {
        $company = Company::factory()->create();

        $response = $this->post(route('company.auth'), [
            'email' => $company->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('company');
        $response->assertStatus(302);
    }

    public function test_companies_can_not_authenticate_with_invalid_password()
    {
        $company = Company::factory()->create();

        $this->post(route('company.auth'), [
            'email' => $company->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
