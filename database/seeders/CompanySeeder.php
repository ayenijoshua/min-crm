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
        Company::factory(['email'=>'check@comp.com'])
        ->has(Employee::factory()->count(5)->employee(), 'employees')
        ->create();
    }
}
