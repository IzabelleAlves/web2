<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Criar Novo Autor</title>
</head>
<body>
    <h1>Criar Novo Autor</h1>

    <form action="{{ route('authors.store') }}" method="POST">
        @csrf
        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" required>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
