<?php

namespace App\Policies;

use App\Models\App;
use App\Models\User;

class AppPolicy
{
    private function ownsVacancyCompany(User $user, App $app): bool
    {
        return $user->id === $app->vacancy->company->owner_id;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, App $app): bool
    {
        return $user->role === 'admin' || $this->ownsVacancyCompany($user, $app);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, App $app): bool
    {
        return $user->role === 'admin' || $this->ownsVacancyCompany($user, $app);
    }

    public function delete(User $user, App $app): bool
    {
        return $user->role === 'admin' || $this->ownsVacancyCompany($user, $app);
    }

    public function restore(User $user, App $app): bool
    {
        return $user->role === 'admin' || $this->ownsVacancyCompany($user, $app);
    }

    public function forceDelete(User $user, App $app): bool
    {
        return false;
    }
}
