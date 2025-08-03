# 📚 API de Biblioteca - Laravel + Postman

Este projeto é uma aplicação de gerenciamento de biblioteca com controle de acesso por tipo de usuário e API para integração e testes.

---

## 🛠️ Como rodar o projeto localmente

### Instale as dependências

composer install
npm install

### Crie e configure o arquivo .env

cp .env.example .env

### Depois, edite o .env e configure o banco de dados:

DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3308
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

### Gere a key da aplicação

php artisan key:generate

### Rode as migrations

php artisan migrate

### Popule o banco com dados iniciais

php artisan db:seed

### Crie o link simbólico para acessar imagens (como capas de livros)

php artisan storage:link

### Rode o frontend

Rode o frontend

### Rode o backend com o servidor Laravel

php artisan serve

### Tipos de Usuários e Permissões

A aplicação possui controle de acesso baseado no tipo de usuário. Existem três tipos de usuário:

🔒 1. Cliente (usuário comum)
Acesso apenas à visualização de dados públicos como livros, autores, editoras e categorias.

Qualquer usuário que se cadastra ou faz login normalmente entra como cliente.

🧑‍🏫 2. Bibliotecário
Pode criar, editar e visualizar dados de:

Livros (Books)

Editoras (Publishers)

Categorias (Categories)

Autores (Authors)

Não pode alterar os papéis de outros usuários.

👑 3. Administrador
Possui acesso total:

-   Pode gerenciar usuários e seus papéis (cliente, bibliotecário, admin).

Tem acesso a rotas restritas como:

/users → Gerenciamento de usuários

/debits → Débitos dos usuários

#### Para acessar como administrador:

Email: admin@biblioteca.com
Senha: admin123

### Como testar a API com o Postman

✅ Listar todos os livros
Método: GET
URL: http://127.0.0.1:8000/api/books
Descrição: Retorna todos os livros cadastrados.

🔍 Buscar um livro específico
Método: GET
URL: http://127.0.0.1:8000/api/books/1
Descrição: Retorna os dados do livro com ID 1.

❌ Erro comum:
Não use {1} literalmente na URL. Use apenas o número direto, sem chaves.

🔍 Para dar um PUT ou POST
{
"id": 1,
"title": "Quam error accusantium voluptatibus rem asperiores sequi.",
"author_id": 1,
"category_id": 10,
"published_id": 1,
"published_year": 2012,
}
