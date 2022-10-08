<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['category_name' => 'Sayur'],
            ['category_name' => 'Daging'],
            ['category_name' => 'Unggas'],
            ['category_name' => 'Seafood'],
            ['category_name' => 'Protein'],
            ['category_name' => 'Bumbu'],
        ];

        foreach($data as $row){
            Category::create([
                'category_name' => $row['category_name']
            ]);
        }
    }
}
