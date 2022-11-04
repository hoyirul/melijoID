<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use Illuminate\Http\Request;

class RecipeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Recipe Category Table';
        $tables = RecipeCategory::all();
        return view('operators.recipe_categories.index', compact([
            'title',
            'tables'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Recipe Category Table';
        return view('operators.recipe_categories.create', compact([
            'title'
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
            'recipe_category_name' => 'required',
        ]);

        RecipeCategory::create([
            'recipe_category_name' => $request->recipe_category_name,
        ]);

        return redirect()->to('/operator/recipe_category')
                    ->with('success', 'Data added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Recipe Category Table';
        $tables = RecipeCategory::where('id', $id)->first();
        return view('operators.recipe_categories.show', compact([
            'title',
            'tables'
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Recipe Category Table';
        $tables = RecipeCategory::where('id', $id)->first();
        return view('operators.recipe_categories.edit', compact([
            'title', 'tables'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'recipe_category_name' => 'required',
        ]);

        RecipeCategory::where('id', $id)->update([
            'recipe_category_name' => $request->recipe_category_name,
        ]);

        return redirect()->to('/operator/recipe_category')
                    ->with('success', 'Data changed successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = RecipeCategory::withCount('recipe')->where('id', $id)->first();
        if($recipe->count() > 0){
            return redirect('/operator/recipe_category')->with('danger', 'This category ('.$recipe->recipe_category_name.') is still used by recipes!');
        }else{
            RecipeCategory::where('id', $id)->delete();
            return redirect('/operator/recipe_category')->with('success', 'Data deleted successfully!');
        }
    }
}
