<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Orden extends Model
{
    /** @use HasFactory<\Database\Factories\OrdenFactory> */
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'buyer_id',
        'total_amount',
        'status',
        'shipping_address',
        'payment_method',
    ];
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
    public function calculateTotal()
    {
        return $this->products->sum(function ($product) {
            return $product->pivot->price * $product->pivot->quantity;
        });
    }
}
