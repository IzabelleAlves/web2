<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Autores</title>
</head>
<body>
    <h1>Autores</h1>
    <a href="{{ route('authors.create') }}">Novo Autor</a>

    <ul>
    @foreach($authors as $author)
        <li>{{ $author->name }} |
            <a href="{{ route('authors.edit', $author->id) }}">Editar</a> |
            <form action="{{ route('authors.destroy', $author->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">Excluir</button>
            </form>
        </li>
    @endforeach
    </ul>
</body>
</html>
