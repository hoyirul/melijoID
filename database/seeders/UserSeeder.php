<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'username' => 'superadmin',
                'email' => 'superadmin@melijo.id',
                'password' => Hash::make('SPRadm@@123'),
                'role_id' => 1
            ],
            [
                'username' => 'admin',
                'email' => 'admin@melijo.id',
                'password' => Hash::make('adm@@157'),
                'role_id' => 2
            ],
            [
                'username' => 'customer',
                'email' => 'customer@melijo.id',
                'password' => Hash::make('customer'),
                'role_id' => 3
            ],
            [
                'username' => 'seller',
                'email' => 'seller@melijo.id',
                'password' => Hash::make('seller'),
                'role_id' => 4
            ],
        ];

        foreach($data as $row){
            User::create([
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => $row['password'],
                'role_id' => $row['role_id'],
                'image' => null
            ]);
        }
    }
}
