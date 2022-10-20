<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\ProductRecipeRecomendation;
use App\Models\Recipe;
use Illuminate\Http\Request;

class ProductRecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $title = 'Product Recipe Table';
        $tables = ProductRecipeRecomendation::with('recipe')->where('recipe_id', $id)->get();
        $recipes = Recipe::where('id', $id)->first();
        return view('operators.recipes.product_recipe', compact([
            'title',
            'tables',
            'recipes'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->image != null){
            $image = $request->file('image')->store('product_recipes/'. $request->recipe_id, 'public');
        }

        ProductRecipeRecomendation::create([
            'recipe_id' => $request->recipe_id,
            'keyword' => $request->keyword,
            'image' => $image,
        ]);

        return redirect()->to('/operator/product_recipe/'. $request->recipe_id . '/show')
                    ->with('success', 'Data added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $recipe_id)
    {
        ProductRecipeRecomendation::where('id', $id)->delete();
        return redirect('/operator/product_recipe/'. $recipe_id .'/show')->with('success', 'Data deleted successfully!');
    }
}
