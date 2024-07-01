<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Jobs\SendLoanNotification;

class LoanController extends Controller
{
    public function index()
    {
        return Loan::with(['user', 'book'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        $loan = Loan::create($request->all());

        SendLoanNotification::dispatch($loan);

        return response()->json($loan->load(['user', 'book']), 201);
    }

    public function show($id)
    {
        return Loan::with(['user', 'book'])->findOrFail($id);
    }
}
