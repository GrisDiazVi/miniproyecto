<?php
namespace App\Policies;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoriaPolicy
{ 
    use HandlesAuthorization;
    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Categoria $categoria): bool
    {
        return true;
    }
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isGerente();
    }
    public function update(User $user, Categoria $categoria): bool
    {
        return $user->isAdmin() || $user->isGerente();
    }
    public function delete(User $user, Categoria $categoria): bool
    {
        return $user->isAdmin() || $user->isGerente();
    }
    public function restore(User $user, Categoria $categoria): bool
    {
        return false;
    }
    public function forceDelete(User $user, Categoria $categoria): bool
    {
        return false;
    }
}
