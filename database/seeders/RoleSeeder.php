<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['role_name' => 'cutsomer'],
            ['role_name' => 'seller'],
            ['role_name' => 'admin'],
            ['role_name' => 'superadmin'],
        ];
    }
}
