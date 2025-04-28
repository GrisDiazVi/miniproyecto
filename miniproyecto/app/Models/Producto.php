<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image_path',
        'seller_id',
        'category_id',
        'status',
    ];
    // Relación con el vendedor (usuario)
    public function seller(): BelongsTo
    { return $this->belongsTo(User::class, 'seller_id'); }
    // Relación con la categoría
    public function category(): BelongsTo
    { return $this->belongsTo(Categoria::class); }
    // Relación muchos a muchos con órdenes (a través de order_items)
    public function orders(): BelongsToMany
    { return $this->belongsToMany(Orden::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps(); } }
