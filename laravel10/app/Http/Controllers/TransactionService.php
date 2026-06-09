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
        $transaction->load('services');

        $services = Service::all();
        $doctors = Doctor::all();

        $selectedServices = $transaction->services->pluck('pivot.quantity', 'id')->toArray();

        return view('transactions.edit', compact('transaction', 'services', 'doctors', 'selectedServices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required',
            'user_notes'       => 'nullable|string',
            'status'           => 'required|in:pending,completed,cancelled',
            'services'         => 'required|array',
            'services.*'       => 'exists:services,id',
            'quantities'       => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $totalPrice = 0;
            $pivotData = [];
            foreach ($request->services as $index => $serviceId) {
                $service = Service::find($serviceId);
                $qty = $request->quantities[$index] ?? 1;

                $totalPrice += $service->price * $qty;
                $pivotData[$serviceId] = [
                    'quantity' => $qty
                ];
            }
            $transaction->update([
                'doctor_id'        => $request->doctor_id,
                'appointment_date' => $request->appointment_date,
                'user_notes'       => $request->user_notes,
                'status'           => $request->status,
                'total_price'      => $totalPrice,
                'service_id'       => $request->services[0],
            ]);
            $transaction->services()->sync($pivotData);

            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('status', 'Gagal memperbarui transaksi: ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        try {
            $transaction->delete();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dipindahkan ke Recycle Bin.');
        } catch (\PDOException $ex) {
            return redirect()->route('transactions.index')->with('status', 'Gagal menghapus data transaksi.');
        }
    }
    public function getEditFormB(Request $request)
    {
        $transaction = Transaction::with('services')->find($request->id);
        $services = \App\Models\Service::all();
        $doctors = \App\Models\Doctor::all();
        $selectedServices = $transaction->services->pluck('pivot.quantity', 'id')->toArray();
        
        return response()->json([
            'status' => 'oke',
            'msg' => view('transactions.getEditFormB', compact('transaction', 'services', 'doctors', 'selectedServices'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $transaction = Transaction::findOrFail($request->id);
        
        $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required',
            'status'           => 'required|in:pending,completed,cancelled,success',
            'services'         => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $totalPrice = 0;
            $pivotData = [];
            
            foreach ($request->services as $serviceId) {
                $service = \App\Models\Service::find($serviceId);
                $qty = $request->quantities[$serviceId] ?? 1;

                $totalPrice += $service->price * $qty;
                $pivotData[$serviceId] = ['quantity' => $qty];
            }

            $transaction->update([
                'doctor_id'        => $request->doctor_id,
                'appointment_date' => $request->appointment_date,
                'user_notes'       => $request->user_notes,
                'status'           => $request->status,
                'total_price'      => $totalPrice,
                'service_id'       => $request->services[0],
            ]);
            
            $transaction->services()->sync($pivotData);
            DB::commit();

            $dateObj = new \DateTime($transaction->appointment_date);
            return response()->json([
                'status' => 'oke',
                'formatted_price' => 'Rp ' . number_format($transaction->total_price, 0, ',', '.'),
                'formatted_date' => $dateObj->format('d/m/Y'),
                'formatted_time' => $dateObj->format('H:i') . ' WIB',
                'trx_status' => $transaction->status,
                'msg' => 'Transaksi berhasil diperbarui!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()], 500);
        }
    }

    public function deleteData(Request $request)
    {
        $transaction = Transaction::find($request->id);
        if ($transaction) {
            $transaction->delete();
            return response()->json(['status' => 'oke', 'msg' => 'Data berhasil dihapus!'], 200);
        }
        return response()->json(['status' => 'error'], 404);
    }
}
