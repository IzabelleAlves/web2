<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Editar Editora</title>
</head>
<body>
    <h1>Editar Editora</h1>

    <form action="{{ route('publishers.update', $publisher->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" value="{{ $publisher->name }}" required>
        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
