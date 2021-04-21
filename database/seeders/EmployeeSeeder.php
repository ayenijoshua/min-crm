<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User as Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Employee::factory(['email'=>'test@employee1'])->employee()
            ->for(Company::factory())
            ->create();
    }
}
