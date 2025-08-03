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
