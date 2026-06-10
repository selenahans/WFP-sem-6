<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view("category.expensiveservice", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("category.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = new Category();
        $data->category_name = $request->name;
        $data->save();

        return redirect()->route('category.expensiveservice')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category->category_name = $request->name;
        $category->save();
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }
public function getEditFormB(Request $request)
{
    $id = $request->id;
    $data = Category::find($id);
    
    return response()->json(array(
        'status' => 'oke',
        'msg' => view('category.getEditFormB', compact('data'))->render() 
    ), 200);
}
public function deleteData(Request $request)
{
    $id = $request->id;
    $data = Category::find($id);
    $data->delete();
    return response()->json(array(
        'status' => 'oke',
        'msg' => 'category data is removed !'
    ), 200);
}
public function saveDataUpdate(Request $request)
{
    $id = $request->id;
    $data = Category::find($id);
    $data->category_name = $request->name;
    $data->save();
    
    return response()->json(array('status' => 'oke', 'msg' => 'category data is up-to-date !'), 200);
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // $this->authorize('delete', $category);
        $this->authorize('delete-permission', Auth::user());

        // try {
        //     $category->delete();
        //     return redirect()->route('category.index')->with(
        //         'success',
        //         'Successfully deleted a category'
        //     );
        // } catch (\PDOException $ex) {
        //     $msg = "Make sure there is no related data before deleting it. Please contact Administrator to know more about it.";
        //     return redirect()->route('category.index')->with(
        //         'status',
        //         $msg
        //     );
        // }
    }
    public function showInfo()
    {
        $highestServiceCategory = Category::withCount('services')
            ->orderByDesc('services_count')
            ->first();

        return response()->json(array(
            'status' => 'oke',
            'msg' => '<div class="alert alert-success">The category with the most services is: <b>' .
                $highestServiceCategory->category_name . '</b></div>'
        ), 200);
    }
    public function showListServices()
    {
        $category = Category::find($_POST['idcat']);
        $name = $category->category_name;
        $data = $category->services;
        return response()->json(array(
            'status' => 'oke',
            'title' => $name . ' Service List',
            'body' => view('category.showListServices', compact('name', 'data'))->render()
        ), 200);
    }

    public function showExpensiveService()
    {

        $categories = Category::with(['services' => function ($query) {
            $query->orderBy('price', 'desc');
        }])->get();

        return view('category.expensiveservice', compact('categories'));
    }
}
