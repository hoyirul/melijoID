<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

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
        $tables = Recipe::all();
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
        return view('operators.recipes.create', compact([
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
            'recipe_title' => 'required',
            'recipe_level' => 'required',
            'step' => 'required',
        ]);

        Recipe::create([
            'recipe_title' => $request->recipe_title,
            'recipe_level' => $request->recipe_level,
            'step' => $request->step,
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
        $tables = Recipe::where('id', $id)->first();
        return view('operators.recipes.show', compact([
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
        $title = 'Recipe Table';
        $tables = Recipe::where('id', $id)->first();
        return view('operators.recipes.edit', compact([
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
            'recipe_title' => 'required',
            'recipe_level' => 'required',
            'step' => 'required',
        ]);

        Recipe::where('id', $id)->update([
            'recipe_title' => $request->recipe_title,
            'recipe_level' => $request->recipe_level,
            'step' => $request->step,
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
