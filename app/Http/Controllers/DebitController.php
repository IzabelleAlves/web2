<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing; // caso você precise pegar empréstimos
use Carbon\Carbon;

class DebitController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with('user', 'book')->get();

        foreach ($borrowings as $borrowing) {
            $today = Carbon::now();
            $dueDate = Carbon::parse($borrowing->borrowed_at)->addDays(15);

            if ($today->greaterThan($dueDate)) {
                $daysLate = $today->diffInDays($dueDate);
                $borrowing->fine = $daysLate * 0.50;
            } else {
                $borrowing->fine = 0;
            }
        }

        return view('debits.index', compact('borrowings'));
    }
}
