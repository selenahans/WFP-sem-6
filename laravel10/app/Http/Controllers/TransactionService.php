<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transaction;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $transactions = Transaction::all();
        $transactions = Transaction::with(['services', 'user'])->get();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        $doctors = Doctor::all(); 
        
        return view('transactions.create', compact('services', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'user_notes'       => 'nullable|string',
            'services'         => 'required|array', 
            'services.*'       => 'exists:services,id',
            'quantities'       => 'required|array',
        ]);

        $totalPrice = 0;
        $pivotData = [];
        foreach ($request->services as $serviceId) {
            $service = Service::find($serviceId);
            $qty = $request->quantities[$serviceId] ?? 1; 
            $totalPrice += $service->price * $qty;
            $pivotData[$serviceId] = [
                'quantity' => $qty
            ];
        }
        $firstServiceId = $request->services[0];
        $transaction = Transaction::create([
            'transaction_code' => 'TRX-' . strtoupper(Str::random(8)),
            'user_id'          => auth()->id() ?? 1,
            'service_id'       => $firstServiceId,  
            'doctor_id'        => $request->doctor_id,
            'total_price'      => $totalPrice,       
            'appointment_date' => $request->appointment_date,
            'user_notes'       => $request->user_notes,
            'status'           => 'pending'
        ]);
        $transaction->services()->attach($pivotData);
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
