<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function index()
    {
        $showArchived = request()->boolean('archived');

        if ($showArchived) {
            $jobSeekers = User::onlyTrashed()->where('role', 'job_seeker')->latest()->get();
            $companyOwners = User::onlyTrashed()->where('role', 'company_owner')->with('companies')->latest()->get();
        } else {
            $jobSeekers = User::where('role', 'job_seeker')->latest()->get();
            $companyOwners = User::where('role', 'company_owner')->with('companies')->latest()->get();
        }

        return view('user.index', compact('jobSeekers', 'companyOwners', 'showArchived'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()->route('users.index')->with('status', 'User updated.');
    }

    
    
    
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('status', "User \"{$user->name}\" has been archived.");
    }

    public function restore(string $user): RedirectResponse
    {
        $model = User::onlyTrashed()->whereKey($user)->firstOrFail();

        $name = $model->name;
        $model->restore();

        return redirect()
            ->route('users.index', ['archived' => true])
            ->with('status', __('User ":name" has been restored.', ['name' => $name]));
    }
}
