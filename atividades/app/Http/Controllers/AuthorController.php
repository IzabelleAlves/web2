<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;


class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $authors = Author::all();
    return view('authors.index', compact('authors'));
}

public function create()
{
    return view('authors.create');
}

public function store(Request $request)
{
    Author::create($request->all());
    return redirect()->route('authors.index');
}

public function edit($id)
{
    $author = Author::findOrFail($id);
    return view('authors.edit', compact('author'));
}

public function update(Request $request, $id)
{
    $author = Author::findOrFail($id);
    $author->update($request->all());
    return redirect()->route('authors.index');
}

public function destroy($id)
{
    Author::destroy($id);
    return redirect()->route('authors.index');
}
}