<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $applications = App::query()
            ->with(['vacancy.company', 'vacancy.category'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        $stats = App::query()
            ->where('user_id', $userId)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('apps.index', [
            'applications' => $applications,
            'stats' => [
                'total' => $stats->sum(),
                'pending' => (int) ($stats['pending'] ?? 0),
                'accepted' => (int) ($stats['accepted'] ?? 0),
                'rejected' => (int) ($stats['rejected'] ?? 0),
            ],
        ]);
    }
}
