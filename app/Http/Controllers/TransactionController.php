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
}
