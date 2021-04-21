<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Set admin user
     */
    public function admin()
    {
        return $this->state([
            'is_admin'=>true
        ]);
    }

    /**
     * Set employee user
     */
    public function employee()
    {
        return $this->state([
            'is_employee'=>true
        ]);
    }

    /**
     * Set test employee
     */
    public function testEmployee()
    {
        return $this->state([
            'email'=>'test@test.com'
        ]);
    }

    /**
     * test
     */
    public function testUser()
    {
        return $this->state([
            'email'=>'test@test.com'
        ]);
    }
}
