<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert([
            [
                'name' => "IT",
                'label' => 'it',
                'flag' => 1,
            ],
            [
                'name' => "Marketing",
                'label' => 'marketing',
                'flag' => 1,
            ],
            [
                'name' => "Finance",
                'label' => 'finance',
                'flag' => 1,
            ],
        ]);
    }
}
