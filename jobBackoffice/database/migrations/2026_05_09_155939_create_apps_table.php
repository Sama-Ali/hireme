<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->float('ai_score',2)->default(0);
            $table->longText('ai_feedback')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreignUuid('resume_id')->references('id')->on('resumes')->onDelete('restrict');
            $table->foreignUuid('vacancy_id')->references('id')->on('vacancies')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps');
    }
};
