<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Auth\Access\Response;

class VacancyPolicy
{
   
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Vacancy $vacancy): bool
    {
        return $user->id === $vacancy->company->owner_id || $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Vacancy $vacancy): bool
    {
        return $user->id === $vacancy->company->owner_id || $user->role === 'admin';
    }

    public function delete(User $user, Vacancy $vacancy): bool
    {
        return $user->id === $vacancy->company->owner_id || $user->role === 'admin';
    }

    public function restore(User $user, Vacancy $vacancy): bool
    {
        return $user->id === $vacancy->company->owner_id || $user->role === 'admin';
    }

    public function forceDelete(User $user, Vacancy $vacancy): bool
    {
        return false;
    }
}
