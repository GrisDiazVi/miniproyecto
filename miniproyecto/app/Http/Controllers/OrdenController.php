<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Http\Requests\StoreOrdenRequest;
use App\Http\Requests\UpdateOrdenRequest;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrdenController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $orders = Orden::where('buyer_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    
    public function create()
    {
        // Asumimos que los productos para ordenar vienen del carrito de compras
        // Esta es una simplificación, normalmente usarías un sistema de carrito
        $cartItems = session()->get('cart', []);
        $products = [];

        if (count($cartItems) > 0) {
            $productIds = array_keys($cartItems);
            $products = Producto::whereIn('id', $productIds)->get();
        }

        return view('orders.create', compact('cartItems', 'products'));
    }

    
    public function store(StoreOrdenRequest $request)
    {
        DB::beginTransaction();

        try {
            $cartItems = session()->get('cart', []);
            if (empty($cartItems)) {
                return redirect()->back()->with('error', 'Tu carrito está vacío');
            }

            $orderData = $request->validated();
            $orderData['buyer_id'] = Auth::id();
            $orderData['total_amount'] = 0; // Se calculará

            // Crear orden
            $order = Orden::create($orderData);

            $total = 0;
            $productIds = array_keys($cartItems);
            $products = Producto::whereIn('id', $productIds)->get();

            foreach ($products as $product) {
                $quantity = $cartItems[$product->id]['quantity'];

                // Verificar stock
                if ($product->stock < $quantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "No hay suficiente stock para {$product->name}");
                }

                // Actualizar stock
                $product->stock -= $quantity;
                $product->save();

                // Añadir producto a la orden
                $order->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'price' => $product->price
                ]);

                $total += $product->price * $quantity;
            }

            // Actualizar total de la orden
            $order->total_amount = $total;
            $order->save();

            // Limpiar carrito
            session()->forget('cart');

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Orden creada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar orden: ' . $e->getMessage());
        }
    }

   
    public function show(Orden $orden)
    {
        $this->authorize('view', $orden);
        return view('orders.show', compact('order'));
    }

    
    public function edit(Orden $orden)
    {
        
    }

   
    public function update(UpdateOrdenRequest $request, Orden $orden)
    {
        $this->authorize('update', $orden);

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $orden->update($validated);
        return redirect()->route('orders.show', $orden)
            ->with('success', 'Estado de orden actualizado');
    }

    
    public function destroy(Orden $orden)
    {
        
    }
}
