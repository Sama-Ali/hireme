<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\User;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $showArchived = request()->boolean('archived');

        $companies = $showArchived
            ? Company::onlyTrashed()->with('owner')->orderBy('name')->get()
            : Company::with('owner')->orderBy('name')->get();

        return view('company.index', compact('companies', 'showArchived'));
    }

    public function create()
    {

        // sent all company owners to the create view so the creator can select the owner of the company
        $users = User::where('role', 'company_owner')->orderBy('name')->get();

        return view('company.create', compact('users'));
    }

    public function store(CompanyRequest $request)
    {
        $company = Company::create($request->validated());

        return redirect()->route('companies.show', $company)
            ->with('status', __('Company created successfully.'));
    }

    public function show(?Company $company = null)
    {
        $company = $this->resolveCompany($company);
        $company->load(['owner', 'vacancies']);

        return view('company.show', compact('company'));
    }

    public function edit(?Company $company = null)
    {
        $company = $this->resolveCompany($company);
        $users = User::where('role', 'company_owner')->orderBy('name')->get();

        return view('company.edit', compact('company', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, ?Company $company = null)
    {
        $company = $this->resolveCompany($company);
        $company->update($request->validated());

        if (request()->routeIs('my-company.*')) {
            return redirect()->route('my-company.show')
                ->with('status', __('Company updated successfully.'));
        }

        return redirect()->route('companies.show', $company)
            ->with('status', __('Company updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')
            ->with('status', __('Company archived successfully.'));
    }

    public function restore(string $company)
    {
        $model = Company::onlyTrashed()->whereKey($company)->firstOrFail();

        $name = $model->name;
        $model->restore();

        return redirect()
            ->route('companies.index', ['archived' => true])
            ->with('status', __('Company ":name" has been restored.', ['name' => $name]));
    }

    private function resolveCompany(?Company $company)
    {
        $company ??= auth()->user()->companies;

        if ($company === null) {
            abort(404, __('No company is assigned to your account.'));
        }

        if (auth()->user()->role === 'company_owner' && $company->owner_id !== auth()->id()) {
            abort(403);
        }

        return $company;
    }
}
