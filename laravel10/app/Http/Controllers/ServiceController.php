<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //raw
        // query builderr
        //eloquent orm
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'available_from' => 'required',
            'available_to' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
        ]);
        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to,
            'category_id' => $request->category_id,
            'price' => $request->price,
        ]);

        return redirect()->route('service.index')->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::findOrFail($id); // Mencari satu data

        // Pastikan nama variabel di compact adalah 'service' (tanpa s)
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
