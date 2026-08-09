<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with(['food', 'user'])->latest()->paginate(10);

        return view('transaction.index', [
            'transactions' => $transactions
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['food', 'user']);

        return view('transaction.detail', [
            'item' => $transaction
        ]);
    }

    /**
     * Update transaction status (quick action from detail page).
     */
    public function changeStatus($id, $status)
    {
        $allowed = ['SUCCESS', 'PENDING', 'CANCELLED', 'DELIVERED', 'ON_DELIVERY'];
        $status = strtoupper($status);

        if (!in_array($status, $allowed)) {
            return redirect()->back()->with('error', 'Status "' . $status . '" tidak valid.');
        }

        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => $status]);

        return redirect()->back()->with('success', 'Status transaksi #' . $transaction->id . ' berhasil diubah menjadi ' . $status . '.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transaction.index');
    }
}
