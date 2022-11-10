<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Category Table';
        $tables = Category::with('product')
                        ->get();
        return view('operators.categories.index', compact([
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
        $title = 'Category Table';
        return view('operators.categories.create', compact([
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
            'category_name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->image != null){
            $image = $request->file('image')->store('categories/', 'public');
        }

        Category::create([
            'category_name' => $request->category_name,
            'image' => $image,
        ]);

        return redirect()->to('/operator/category')
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
        $title = 'Category Table';
        $tables = Category::where('id', $id)->first();
        return view('operators.categories.show', compact([
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
        $title = 'Category Table';
        $tables = Category::where('id', $id)->first();
        return view('operators.categories.edit', compact([
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
            'category_name' => 'required',
        ]);

        $image = null;
        $tables = Category::where('id', $id)->first();
        if($tables->image && file_exists(storage_path('app/public/'. $tables->image))){
            Storage::delete(['public/', $tables->image]);
        }
        
        if($request->image != null){
            $image = $request->file('image')->store('categories', 'public');
        }

        Category::where('id', $id)->update([
            'category_name' => $request->category_name,
            'image' => ($image == null) ? $tables->image : $image,
        ]);

        return redirect()->to('/operator/category')
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
        $category = Category::withCount('product')->where('id', $id)->first();
        if($category->count() > 0){
            return redirect('/operator/category')->with('danger', 'This category ('.$category->category_name.') is still used by product!');
        }else{
            Category::where('id', $id)->delete();
            return redirect('/operator/category')->with('success', 'Data deleted successfully!');
        }
    }
}
