<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksControllerApi extends Controller
{
    // Listar todos os livros
    public function index()
    {
        // Carrega relações se quiser: with(['author', 'publisher', 'category'])
        $books = Book::all();
        return response()->json($books);
    }

    // Criar um novo livro
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'author_id'       => 'required|exists:authors,id',
            'category_id'     => 'required|exists:categories,id',
            'publisher_id'    => 'nullable|exists:publishers,id',
            'published_year'  => 'nullable|integer',
            'cover'           => 'nullable|string',
        ]);

        $book = Book::create($validated);

        return response()->json($book, 201);
    }

    // Mostrar um livro específico
    public function show($id)
    {
        $book = Book::with(['author', 'publisher', 'category'])->find($id);

        if (!$book) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        return response()->json($book);
    }

    // Atualizar um livro
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        $validated = $request->validate([
            'title'           => 'sometimes|required|string|max:255',
            'author_id'       => 'sometimes|required|exists:authors,id',
            'category_id'     => 'sometimes|required|exists:categories,id',
            'publisher_id'    => 'nullable|exists:publishers,id',
            'published_year'  => 'nullable|integer',
            'cover'           => 'nullable|string',
        ]);

        $book->update($validated);

        return response()->json($book);
    }

    // Deletar um livro
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        // Se quiser remover capa do storage aqui, faça a lógica semelhante ao BookController web

        $book->delete();

        return response()->json(['message' => 'Livro deletado com sucesso']);
    }
}
