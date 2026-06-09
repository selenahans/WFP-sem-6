<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'specialist' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'experience_years' => 'required|integer',
        ]);

        $doctor = new Doctor();
        $doctor->name = $request->name;
        $doctor->license_number = $request->license_number;
        $doctor->specialist = $request->specialist;
        $doctor->phone_number = $request->phone_number;
        $doctor->experience_years = $request->experience_years;
        $doctor->is_active = 1; 
        $doctor->save();

        return redirect()->route('doctor.index')->with('success', 'Data Dokter berhasil ditambahkan.');
    }
    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Doctor::find($id);
        
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('doctors.getEditFormB', compact('data'))->render()
        ), 200);
    }
    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $doctor = Doctor::find($id);
        
        $doctor->name = $request->name;
        $doctor->license_number = $request->license_number;
        $doctor->specialist = $request->specialist;
        $doctor->phone_number = $request->phone_number;
        $doctor->experience_years = $request->experience_years;
        $doctor->is_active = $request->is_active;
        $doctor->save();
        
        return response()->json(array(
            'status' => 'oke', 
            'msg' => 'Data dokter berhasil diperbarui!'
        ), 200);
    }
    public function deleteData(Request $request)
{
    $id = $request->id;
    $doctor = Doctor::find($id);
    
    if ($doctor) {
        $doctor->delete(); 
        return response()->json(array(
            'status' => 'oke',
            'msg' => 'Data dokter berhasil dinonaktifkan (soft delete)!'
        ), 200);
    }

    return response()->json(array(
        'status' => 'error',
        'msg' => 'Data tidak ditemukan.'
    ), 404);
}
}