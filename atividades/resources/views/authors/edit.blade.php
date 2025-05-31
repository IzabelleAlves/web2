<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Editar Autor</title>
</head>
<body>
    <h1>Editar Autor</h1>

    <form action="{{ route('authors.update', $author->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" value="{{ $author->name }}" required>
        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
