<?php

namespace Database\Seeders;

use App\Models\UserCustomer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCustomerSeeder extends Seeder
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
                'user_id' => 3,
                'name' => 'Customer Test',
                'phone' => '12345678'
            ]
        ];

        foreach($data as $row){
            UserCustomer::create([
                'user_id' => $row['user_id'],
                'name' => $row['name'],
                'phone' => $row['phone']
            ]);
        }
    }
}
