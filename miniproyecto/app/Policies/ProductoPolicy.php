<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductoPolicy
{
    use HandlesAuthorization;
    /
    public function viewAny(User $user): bool
    {
        return true;
    }

    
    public function view(User $user, Producto $producto): bool
    {
        return true;
    }

   
    public function create(User $user): bool
    {
        return $user->isClient();
    }

    public function update(User $user, Producto $producto): bool
    {
        return $user->id === $producto->seller_id || $user->isAdmin();
    }

    public function delete(User $user, Producto $producto): bool
    {
        return $user->id === $producto->seller_id || $user->isAdmin();
    }

    public function restore(User $user, Producto $producto): bool
    {
        return false;
    }
    public function forceDelete(User $user, Producto $producto): bool
    {
        return false;
    }
}
