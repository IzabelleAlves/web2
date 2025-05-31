<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Editoras</title>
</head>
<body>
    <h1>Editoras</h1>
    <a href="{{ route('publishers.create') }}">Nova Editora</a>

    <ul>
    @foreach($publishers as $publisher)
        <li>{{ $publisher->name }} |
            <a href="{{ route('publishers.edit', $publisher->id) }}">Editar</a> |
            <form action="{{ route('publishers.destroy', $publisher->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">Excluir</button>
            </form>
        </li>
    @endforeach
    </ul>
</body>
</html>
