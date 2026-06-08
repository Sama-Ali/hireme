<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppRequest;
use App\Models\App;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        // show archived apps
        $showArchived = request()->boolean('archived');

        $query = App::latest();

        if (auth()->user()->role == 'company_owner') {
            $query->whereHas('vacancy', function ($query) {
                $query->where('company_id', auth()->user()->companies->id);
            });
        }

        // show archived apps
        if ($showArchived) {
            $query->onlyTrashed();
        }

        $apps = $query->paginate(10)->onEachSide(1);

        return view('app.index', compact('apps', 'showArchived'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(App $app)
    {
        $this->authorize('view', $app);

        $app->load(['user', 'vacancy.company', 'vacancy.category', 'resume']);

        return view('app.show', compact('app'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(App $app)
    {
        return view('app.edit', compact('app'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppRequest $request, App $app)
    {
        $this->authorize('update', $app);

        $app->update($request->validated());

        return redirect()->route('apps.show', $app)->with('status', 'application-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(App $app)
    {
        $app->delete();

        return redirect()->route('apps.index')->with('status', 'Application has been archived.');
    }

    /**
     * Restore a soft-deleted application from the archived list.
     */
    public function restore(string $app): RedirectResponse
    {
        $model = App::onlyTrashed()->whereKey($app)->firstOrFail();

        $label = $model->user?->name ?? __('Unknown Applicant');
        $model->restore();

        return redirect()
            ->route('apps.index', ['archived' => true])
            ->with('status', __('Application for ":name" has been restored.', ['name' => $label]));
    }
}
