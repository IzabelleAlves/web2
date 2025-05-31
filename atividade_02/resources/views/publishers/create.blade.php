<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Criar Nova Editora</title>
</head>
<body>
    <h1>Criar Nova Editora</h1>

    <form action="{{ route('publishers.store') }}" method="POST">
        @csrf
        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" required>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
