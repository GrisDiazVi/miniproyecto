<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    
    public function run(): void
    {
        // Asegurarse que hay usuarios y categorías disponibles
        $clientUsers = User::where('role', 'cliente')->get();
        $categories = Categoria::all();

        if ($clientUsers->isEmpty()) {
            $this->command->info('No hay usuarios clientes. Creando uno...');
            $user = User::factory()->create(['role' => 'cliente']);
            $clientUsers = User::where('role', 'cliente')->get();
        }

        if ($categories->isEmpty()) {
            $this->command->info('No hay categorías. Ejecuta el CategorySeeder primero.');
            return;
        }

        // Crear productos usando factory
        Producto::factory()->count(20)->create();

        // Crear algunos productos manualmente
        $electronicsCategory = Categoria::where('name', 'Electrónica')->first();
        if ($electronicsCategory) {
            Producto::create([
                'name' => 'Smartphone Premium',
                'description' => 'Último modelo con características avanzadas',
                'price' => 999.99,
                'stock' => 15,
                'seller_id' => $clientUsers->random()->id,
                'category_id' => $electronicsCategory->id,
                'status' => 'active',
            ]);
        }
    }
}
