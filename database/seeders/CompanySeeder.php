<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User as Employee;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::factory([
            'email'=>'test@company.com',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ])->hash(Employee::factory(['email'=>'test@employee.com','is_employee'=>true]))
        ->state(function (array $attributes, Company $company) {
            return ['company_id' => $company->id];
        })
        ->create();
    }
}
