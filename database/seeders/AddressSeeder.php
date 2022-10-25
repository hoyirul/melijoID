<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
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
                'province' => 1,
                'city' => 2,
                'districts' => 3,
                'ward' => 3,
            ],
            [
                'province' => 1,
                'city' => 3,
                'districts' => 2,
                'ward' => 4,
            ],
            [
                'province' => 1,
                'city' => 2,
                'districts' => 4,
                'ward' => 2,
            ],
            [
                'province' => 1,
                'city' => 2,
                'districts' => 4,
                'ward' => 2,
            ],
        ];

        foreach($data as $row){
            Address::create([
                'province' => $row['province'],
                'city' => $row['city'],
                'districts' => $row['districts'],
                'ward' => $row['ward'],
            ]);
        }
    }
}
