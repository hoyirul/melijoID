<?php

namespace Database\Seeders;

use App\Models\UserAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
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
                'addresses_id' => 1,
            ],
            [
                'user_id' => 2,
                'addresses_id' => 2,
            ],
            [
                'user_id' => 3,
                'addresses_id' => 3,
            ],
            [
                'user_id' => 4,
                'addresses_id' => 4,
            ],
        ];

        foreach($data as $row){
            UserAddress::create([
                'user_id' => $row['user_id'],
                'addresses_id' => $row['addresses_id'],
            ]);
        }
    }
}
