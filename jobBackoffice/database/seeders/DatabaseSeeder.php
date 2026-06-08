<?php

namespace Database\Seeders;

use App\Models\App;
use App\Models\Resume;
use App\Models\User;
use App\Models\Vacancy;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Company;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // seed admin user
        User::firstOrCreate(['email' => 'admin@example.com'],[
            'name' => 'Admin User',
            'password' => '12345678',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        

        // seed data
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $appsData = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        // seed categories
        foreach ($jobData['categories'] as $category) {
            Category::firstOrCreate([
                'name' => $category,
            ]);
        }

        // seed companies
        foreach ($jobData['companies'] as $company) {
            // creeate company owner
            $owner = User::firstOrCreate(['email' => fake()->unique()->safeEmail()],[
                'name' => fake()->name(),
                'password' => Hash::make('12345678'),
                'role' => 'company_owner',
                'email_verified_at' => now(),
            ]);

            Company::firstOrCreate(['name' => $company['name']],[
                'location' => $company['location'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'owner_id' => $owner->id,
            ]);
        }

        // seed vacancies
        foreach ($jobData['vacancies'] as $vacancy) {
            // get the created company 
            $company = Company::where('name', $vacancy['company'])->firstOrFail();
            // get the category
            $category = Category::where('name', $vacancy['category'])->firstOrFail();

            Vacancy::firstOrCreate(['title' => $vacancy['title'],'company_id' => $company->id,
        ],[
                'description' => $vacancy['description'],
                'location' => $vacancy['location'],
                'salary' => $vacancy['salary'],
                'type' => $vacancy['type'],
                'category_id' => $category->id,
            ]);
        }

        // seed apps
        foreach ($appsData['jobApplications'] as $app) {
            // get random vacancy
            $vacancy = Vacancy::inRandomOrder()->firstOr();

            // create job seeker user
            $jobSeeker = User::firstOrCreate(['email' => fake()->unique()->safeEmail()],[
                'name' => fake()->name(),
                'password' => Hash::make('12345678'),
                'role' => 'job_seeker',
                'email_verified_at' => now(),
            ]);
            
            // create resume
            $resume = Resume::create([
                'user_id' => $jobSeeker->id,
                'name' => $app['resume']['name'],
                'url' => $app['resume']['url'],
                'contact' => $app['resume']['contact'],
                'summary' => $app['resume']['summary'],
                'skills' => $app['resume']['skills'],
                'experience' => $app['resume']['experience'],
                'education' => $app['resume']['education'],
            ]);
            // create app
            App::create([
                'user_id' => $jobSeeker->id,
                'resume_id' => $resume->id,
                'vacancy_id' => $vacancy->id,
                'status' => $app['status'],
                'ai_score' => $app['ai_score'],
                'ai_feedback' => $app['ai_feedback'],
            ]);

    }
  }
}
