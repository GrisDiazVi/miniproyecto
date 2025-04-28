<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electrónica',
                'description' => 'Artículos electrónicos como teléfonos, computadoras y más',
            ],
            [
                'name' => 'Ropa',
                'description' => 'Todo tipo de prendas de vestir',
            ],
            [
                'name' => 'Hogar',
                'description' => 'Artículos para el hogar y la decoración',
            ],
            [
                'name' => 'Libros',
                'description' => 'Libros de diversos géneros',
            ],
            [
                'name' => 'Deportes',
                'description' => 'Equipamiento deportivo y accesorios',
            ]
        ];

        foreach ($categories as $category) {
            Categoria::create($category);
        }

        // Crear categorías adicionales con factory
        Categoria::factory()->count(5)->create();
    }
}
