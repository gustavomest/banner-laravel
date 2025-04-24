<?php

namespace App\Policies;

use App\Models\User;

class TaskPolicy
{
    public function create(User $user)
{
    return true; // Ou outra lógica de autorização
}
}
