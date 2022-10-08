<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['unit_name' => 'PCS'],
            ['unit_name' => 'KG'],
            ['unit_name' => 'GR'],
            ['unit_name' => 'IKAT'],
        ];

        foreach($data as $row){
            Unit::create([
                'unit_name' => $row['unit_name']
            ]);
        }
    }
}
