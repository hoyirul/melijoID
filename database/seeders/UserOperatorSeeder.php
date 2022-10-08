<?php

namespace Database\Seeders;

use App\Models\UserOperator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserOperatorSeeder extends Seeder
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
                'user_id' => 1,
                'name' => 'SUPER ADMIN',
                'phone' => '12345678'
            ],
            [
                'user_id' => 2,
                'name' => 'ADMIN',
                'phone' => '12345678'
            ],
        ];

        foreach($data as $row){
            UserOperator::create([
                'user_id' => $row['user_id'],
                'name' => $row['name'],
                'phone' => $row['phone']
            ]);
        }
    }
}
