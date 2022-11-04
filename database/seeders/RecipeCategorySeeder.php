<?php

namespace Database\Seeders;

use App\Models\RecipeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['recipe_category_name' => 'Healty Food'],
            ['recipe_category_name' => 'Asian Food'],
            ['recipe_category_name' => 'Midle Food'],
            ['recipe_category_name' => 'Korean Food'],
        ];

        foreach($data as $row){
            RecipeCategory::create([
                'recipe_category_name' => $row['recipe_category_name']
            ]);
        }
    }
}
