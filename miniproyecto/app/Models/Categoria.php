<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
class Categoria extends Model
{   /** @use HasFactory<\Database\Factories\CategoriaFactory> */
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'description',
    ];
    public function products(): HasMany
    { return $this->hasMany(Producto::class);
    } public function orders(): HasManyThrough
    {   return $this->hasManyThrough(
            Orden::class,
            Producto::class,
            'category_id', // Clave externa en productos
            'id', // Clave primaria en órdenes
            'id', // Clave primaria en categorías
            'id' // Clave en productos que conecta con órdenes 
    );
    }
}
