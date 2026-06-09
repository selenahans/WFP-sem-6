<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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
        $data = new Category();
        $data->category_name = $request->get('name');
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
        // 1. Ambil data category berdasarkan ID terlebih dahulu
        $category = Category::findOrFail($id);

        // 2. Sekarang compact('category') tidak akan error lagi karena variabelnya sudah ada
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255',
        ]);
        $category->category_name = $request->categoryName;
        $category->save();
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        try {
            $category->delete();
            return redirect()->route('category.index')->with(
                'success',
                'Successfully deleted a category'
            );
        } catch (\PDOException $ex) {
            $msg = "Make sure there is no related data before deleting it. Please contact Administrator to know more about it.";
            return redirect()->route('category.index')->with(
                'status',
                $msg
            );
        }
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
