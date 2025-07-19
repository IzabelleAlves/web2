<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Formulário com input de ID
    public function createWithId()
    {
        return view('books.create-id');
    }

    // Listar livros com paginação e eager loading do autor
    public function index()
    {
        $books = Book::with('author')->paginate(20);
        return view('books.index', compact('books'));
    }

    // Mostrar formulário de edição com dados de autores, editoras e categorias
    public function edit(Book $book)
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.edit', compact('book', 'publishers', 'authors', 'categories'));
    }

    // Atualizar livro, incluindo troca de imagem de capa
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id'    => 'required|exists:authors,id',
            'category_id'  => 'required|exists:categories,id',
            'cover'        => 'nullable|image|max:2048',
        ]);

        // Substituir capa se uma nova for enviada
        if ($request->hasFile('cover')) {
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            $data['cover'] = $request->file('cover')->store('book_covers', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso.');
    }

    // Novo: Remover apenas a capa do livro (sem deletar o livro)
    public function removeCover(Book $book)
    {
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
            $book->cover = null;
            $book->save();
        }

        return redirect()->back()->with('success', 'Capa removida com sucesso.');
    }

    // Mostrar detalhes do livro + formulário de empréstimo
    public function show(Book $book)
    {
        $book->load(['author', 'publisher', 'category']);
        $users = User::all();

        return view('books.show', compact('book', 'users'));
    }

    // Formulário com input select para criação
    public function createWithSelect()
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.create-select', compact('publishers', 'authors', 'categories'));
    }

    // Salvar novo livro com validação e upload opcional da capa
    public function storeWithSelect(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id'    => 'required|exists:authors,id',
            'category_id'  => 'required|exists:categories,id',
            'cover'        => 'nullable|image|max:2048',
        ]);

        $data['cover'] = $request->hasFile('cover')
            ? $request->file('cover')->store('book_covers', 'public')
            : null;

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    // Salvar livro com input de ID (sem upload)
    public function storeWithId(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id'    => 'required|exists:authors,id',
            'category_id'  => 'required|exists:categories,id',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    // Deletar livro e sua imagem de capa se existir
    public function destroy(Book $book)
    {
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro deletado com sucesso.');
    }
}
