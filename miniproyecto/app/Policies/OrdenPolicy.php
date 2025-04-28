<?php

namespace App\Policies;

use App\Models\Orden;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrdenPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Orden $orden): bool
    {
        return $user->id === $orden->buyer_id || $user->isAdmin() || $user->isGerente();
    }
    public function create(User $user): bool
    {
        return true;
    }
    public function update(User $user, Orden $orden): bool
    {
        return $user->isAdmin() || $user->isGerente() ||
            ($user->id === $orden->buyer_id && $orden->status === 'pending');
    }
    public function delete(User $user, Orden $orden): bool
    {
        return false;
    }
    public function restore(User $user, Orden $orden): bool
    {
        return false;
    }
    public function forceDelete(User $user, Orden $orden): bool
    {
        return false;
    }
}
