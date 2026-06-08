<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Company;
use App\Models\Vacancy;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
       if(auth()->user()->role == 'admin'){
        return $this->adminDashboard();
       } else {
        return $this->companyOwnerDashboard();
       }
    }

    public function adminDashboard(){
    // active job seekers count for the last 30 days
    $activeJobSeekersCount = User::query()
         ->where('last_login_at', '>=', now()->subDays(30))
         ->where('role', 'job_seeker')
         ->count();
     $activeVacanciesCount = Vacancy::query()->count();
     $applicationsCount = App::query()->count();
     $companiesCount = Company::query()->count();

     $mostAppliedVacancies = Vacancy::query()
         ->with(['company', 'category'])
         ->withCount('apps')
         ->whereHas('apps')
         ->orderByDesc('apps_count')
         ->limit(10)
         ->get();

     $topCompanies = Company::query()
         ->withCount('vacancies')
         ->orderByDesc('vacancies_count')
         ->limit(3)
         ->get();

     $convertingJobPost = Vacancy::query()
         ->withCount('apps')
         ->having('apps_count', '>', 0)
         ->get()
         ->map(function (Vacancy $vacancy): array {
             $views = (int) $vacancy->views;
             $ratePercent = $views > 0
                 ? round(($vacancy->apps_count / $views) * 100, 1)
                 : null;

             return [
                 'vacancy' => $vacancy,
                 'conversion_rate_percent' => $ratePercent,
             ];
         })
         ->sort(function (array $a, array $b): int {
             $rateA = $a['conversion_rate_percent'];
             $rateB = $b['conversion_rate_percent'];

             if ($rateA !== null && $rateB !== null && $rateA !== $rateB) {
                 return $rateB <=> $rateA;
             }
             if ($rateA !== null && $rateB === null) {
                 return -1;
             }
             if ($rateA === null && $rateB !== null) {
                 return 1;
             }

             return $b['vacancy']->apps_count <=> $a['vacancy']->apps_count;
         })
         ->take(5)
         ->values();

     return view('dashboard.index', [
         'activeJobSeekersCount' => $activeJobSeekersCount,
         'activeVacanciesCount' => $activeVacanciesCount,
         'applicationsCount' => $applicationsCount,
         'companiesCount' => $companiesCount,
         'mostAppliedVacancies' => $mostAppliedVacancies,
         'topCompanies' => $topCompanies,
         'convertingJobPost' => $convertingJobPost,
     ]);
    }

    public function companyOwnerDashboard(){
        $company = auth()->user()->companies;

        $activeJobSeekersCount = User::query()
         ->where('last_login_at', '>=', now()->subDays(30))
         ->where('role', 'job_seeker')
         ->whereHas('apps', function($query) use ($company){
            $query->whereHas('vacancy', function($query) use ($company){
                $query->where('company_id', $company->id);
            });
         })->count();

        $activeVacanciesCount = $company->vacancies->count();

        $applicationsCount = App::whereIn('vacancy_id', $company->vacancies->pluck('id'))->count();

        $mostAppliedVacancies = Vacancy::query()
         ->with(['company', 'category'])
         ->withCount('apps')
         ->whereHas('apps', function($query) use ($company){
            $query->whereHas('vacancy', function($query) use ($company){
                $query->where('company_id', $company->id);
            });
         })
         ->orderByDesc('apps_count')
         ->limit(10)
         ->get();

         $convertingJobPost = Vacancy::query()
         ->withCount('apps')
         ->having('apps_count', '>', 0)
         ->whereHas('apps', function($query) use ($company){
            $query->whereHas('vacancy', function($query) use ($company){
                $query->where('company_id', $company->id);
            });
         })
         ->get()
         ->map(function (Vacancy $vacancy): array {
             $views = (int) $vacancy->views;
             $ratePercent = $views > 0
                 ? round(($vacancy->apps_count / $views) * 100, 1)
                 : null;

             return [
                 'vacancy' => $vacancy,
                 'conversion_rate_percent' => $ratePercent,
             ];
         })
         ->sort(function (array $a, array $b): int {
             $rateA = $a['conversion_rate_percent'];
             $rateB = $b['conversion_rate_percent'];

             if ($rateA !== null && $rateB !== null && $rateA !== $rateB) {
                 return $rateB <=> $rateA;
             }
             if ($rateA !== null && $rateB === null) {
                 return -1;
             }
             if ($rateA === null && $rateB !== null) {
                 return 1;
             }

             return $b['vacancy']->apps_count <=> $a['vacancy']->apps_count;
         })
         ->take(5)
         ->values();

        return view('dashboard.index', [
            'activeJobSeekersCount' => $activeJobSeekersCount,
            'activeVacanciesCount' => $activeVacanciesCount,
            'applicationsCount' => $applicationsCount,
            'mostAppliedVacancies' => $mostAppliedVacancies,
            'convertingJobPost' => $convertingJobPost,
        ]);
    }
}
