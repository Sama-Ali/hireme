<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacancyRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Http\RedirectResponse;

class VacancyController extends Controller
{
    public function index()
    {
        $showArchived = request()->boolean('archived');

        $query = Vacancy::with(['company', 'category'])->latest();

        if (auth()->user()->role == 'company_owner') {
            $query->where('company_id', auth()->user()->companies->id);
        }

        if ($showArchived) {
            $query->onlyTrashed();
        }

        $vacancies = $query->get();

        return view('vacancy.index', compact('vacancies', 'showArchived'));
    }
    public function create()
    {
        if(auth()->user()->role == 'company_owner'){
            $companies = Company::where('owner_id', auth()->user()->id)->get();
        } else {
            $companies = Company::all();
        }
        $categories = Category::all();
        return view('vacancy.create', compact('companies', 'categories'));
    }

    public function store(VacancyRequest $request)
    {
        Vacancy::create($request->validated());

        return redirect()->route('vacancies.index')->with('status', 'Vacancy created successfully.');
    }

    public function show(Vacancy $vacancy)
    {
        $this->authorize('view', $vacancy);

        return view('vacancy.show', compact('vacancy'));
    }

    public function edit(Vacancy $vacancy)
    {
        $companies = Company::all();
        $categories = Category::all();

        return view('vacancy.edit', compact('vacancy', 'companies', 'categories'));
    }

    public function update(VacancyRequest $request, Vacancy $vacancy)
    {
        $this->authorize('update', $vacancy);

        $vacancy->update($request->validated());

        return redirect()->route('vacancies.show', $vacancy)->with('status', 'Vacancy updated successfully.');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return redirect()->route('vacancies.index')->with('status', 'Vacancy deleted successfully.');
    }

    public function restore(string $vacancy): RedirectResponse
    {
        $model = Vacancy::onlyTrashed()->whereKey($vacancy)->firstOrFail();

        $title = $model->title;
        $model->restore();

        return redirect()
            ->route('vacancies.index', ['archived' => true])
            ->with('status', __('Vacancy ":title" has been restored.', ['title' => $title]));
    }
}
