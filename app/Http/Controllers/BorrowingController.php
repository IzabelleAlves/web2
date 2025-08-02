<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        // Verifica se o livro já está emprestado
        $emprestimoEmAberto = Borrowing::where('book_id', $book->id)
            ->whereNull('returned_at')
            ->exists();

        if ($emprestimoEmAberto) {
            return redirect()->route('books.show', $book)
                ->with('error', 'Este livro já está emprestado e ainda não foi devolvido.');
        }

        // Verifica se o usuário possui débito pendente
        if ($user->debit > 0) {
            return redirect()->route('books.show', $book)
                ->with('error', 'Empréstimo não realizado. Este usuário possui débito pendente de R$ ' . number_format((float) $user->debit, 2, ',', '.'));

        }

        // Verifica se o usuário já tem 5 empréstimos em aberto
        $emprestimosAtivos = Borrowing::where('user_id', $user->id)
            ->whereNull('returned_at')
            ->count();

        if ($emprestimosAtivos >= 5) {
            return redirect()->route('books.show', $book)
                ->with('error', 'Empréstimo não realizado. Este usuário já possui 5 livros emprestados.');
        }

        // Cria o empréstimo
        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        return redirect()->route('books.show', $book)
            ->with('success', 'Empréstimo registrado com sucesso.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        $borrowedAt = Carbon::parse($borrowing->borrowed_at);
        $returnedAt = now();
        $diasEmprestado = $borrowedAt->diffInDays($returnedAt);
        $diasDeAtraso = $diasEmprestado - 15;
        $mensagemMulta = '';

        if ($diasDeAtraso > 0) {
            $multa = $diasDeAtraso * 0.5;

            $user = $borrowing->user;
            $user->debit += $multa;
            $user->save();

            $mensagemMulta = " Houve atraso de $diasDeAtraso dias. Multa de R$ " . number_format($multa, 2, ',', '.') . " adicionada ao usuário.";
        }

        $borrowing->update([
            'returned_at' => $returnedAt,
        ]);

        return redirect()->route('books.show', $borrowing->book_id)
            ->with('success', 'Devolução registrada com sucesso.' . $mensagemMulta);
    }

    public function userBorrowings(User $user)
    {
        $borrowings = $user->books()->withPivot('borrowed_at', 'returned_at')->get();
        return view('users.borrowings', compact('user', 'borrowings'));
    }

    // Interface do bibliotecário para ver e quitar multas
    public function debits()
    {
        $usuariosComDebito = User::where('debit', '>', 0)->get();
        return view('admin.debits', compact('usuariosComDebito'));
    }

    public function zerarDebito(User $user)
    {
        $user->debit = 0;
        $user->save();

        return redirect()->route('admin.debits')->with('success', 'Débito do usuário zerado com sucesso.');
    }
}
