<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Recipe Table';
        $tables = Recipe::with('recipe_category')->get();
        return view('operators.recipes.index', compact([
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
        $title = 'Recipe Table';
        $categories = RecipeCategory::all();
        return view('operators.recipes.create', compact([
            'title', 'categories'
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
            'recipe_title' => 'required',
            'recipe_category_id' => 'required',
            'step' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->image != null){
            $image = $request->file('image')->store('recipes', 'public');
        }

        Recipe::create([
            'recipe_title' => $request->recipe_title,
            'recipe_category_id' => $request->recipe_category_id,
            'step' => $request->step,
            'image' => $image,
        ]);

        return redirect()->to('/operator/recipe')
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
        $title = 'Recipe Table';
        $categories = RecipeCategory::all();
        $tables = Recipe::with('recipe_category')->where('id', $id)->first();
        return view('operators.recipes.show', compact([
            'title',
            'tables',
            'categories'
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
        $title = 'Recipe Table';
        $categories = RecipeCategory::all();
        $tables = Recipe::with('recipe_category')->where('id', $id)->first();
        return view('operators.recipes.edit', compact([
            'title', 'tables', 'categories'
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
            'recipe_title' => 'required',
            'recipe_category_id' => 'required',
            'step' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $tables = Recipe::where('id', $id)->first();

        $image = null;

        if($tables->image && file_exists(storage_path('app/public/'. $tables->image))){
            Storage::delete(['public/', $tables->image]);
        }

        if($request->image != null){
            $image = $request->file('image')->store('recipes', 'public');
        }

        Recipe::where('id', $id)->update([
            'recipe_title' => $request->recipe_title,
            'recipe_category_id' => $request->recipe_category_id,
            'step' => $request->step,
            'image' => $image,
        ]);

        return redirect()->to('/operator/recipe')
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
        Recipe::where('id', $id)->delete();
        return redirect('/operator/recipe')->with('success', 'Data deleted successfully!');
    }
}
