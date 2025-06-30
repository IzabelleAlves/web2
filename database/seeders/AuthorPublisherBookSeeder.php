<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class AuthorPublisherBookSeeder extends Seeder
{
    public function run()
    {
        // Gera 100 autores, cada um com 10 livros
        Author::factory(100)->create()->each(function ($author) {
            // Cria uma editora para cada autor
            $publisher = Publisher::factory()->create();

            // Cria 10 livros para cada autor, associando uma categoria aleatória e capa padrão
            $author->books()->createMany(
                Book::factory(10)->make([
                    'category_id' => Category::inRandomOrder()->first()->id,
                    'publisher_id' => $publisher->id,
                    'cover' => 'book_covers/default.jpg', // caminho da imagem padrão
                ])->toArray()
            );
        });
    }
}
