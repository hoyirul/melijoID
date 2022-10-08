<?php

namespace Database\Seeders;

use App\Models\UserSeller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSellerSeeder extends Seeder
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
                'user_id' => 4,
                'name' => 'Seller Test',
                'phone' => '12345678'
            ]
        ];

        foreach($data as $row){
            UserSeller::create([
                'user_id' => $row['user_id'],
                'name' => $row['name'],
                'phone' => $row['phone']
            ]);
        }
    }
}
