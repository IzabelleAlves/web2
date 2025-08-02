<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;



class BorrowingController extends Controller
{

public function store(Request $request, Book $book)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $user_id = $request->user_id;

    // Verifica se já existe um empréstimo em aberto para este livro
    $emprestimoEmAberto = Borrowing::where('book_id', $book->id)
        ->whereNull('returned_at')
        ->exists();

    if ($emprestimoEmAberto) {
        return redirect()->route('books.show', $book)
            ->with('error', 'Este livro já está emprestado e ainda não foi devolvido.');
    }

    // Verifica quantos livros o usuário tem emprestados sem devolução
    $totalEmprestimosAtivos = Borrowing::where('user_id', $user_id)
        ->whereNull('returned_at')
        ->count();

    if ($totalEmprestimosAtivos >= 5) {
        return redirect()->route('books.show', $book)
            ->with('error', 'Empréstimo não realizado. Este usuário já possui 5 livros emprestados.');
    }

    // Cria o novo empréstimo
    Borrowing::create([
        'user_id'     => $user_id,
        'book_id'     => $book->id,
        'borrowed_at' => now(),
    ]);

    return redirect()->route('books.show', $book)
        ->with('success', 'Empréstimo registrado com sucesso.');
}


    public function returnBook(Borrowing $borrowing)
    {
        $borrowing->update([
            'returned_at' => now(),
        ]);

        return redirect()->route('books.show', $borrowing->book_id)->with('success', 'Devolução registrada com sucesso.');
    }

    public function userBorrowings(User $user)
    {
        $borrowings = $user->books()->withPivot('borrowed_at', 'returned_at')->get();

        return view('users.borrowings', compact('user', 'borrowings'));
    }

}
