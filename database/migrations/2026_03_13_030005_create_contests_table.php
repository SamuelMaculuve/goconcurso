<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('contest_categories')->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->enum('location_type', ['local', 'national', 'international', 'remote'])->default('national');
            $table->string('professional_area')->nullable();
            $table->enum('contest_type', ['public_contest', 'job', 'scholarship', 'tender', 'project_call', 'internship', 'consulting']);
            $table->enum('participation_type', ['info_only', 'interest_submission', 'full_application'])->default('full_application');
            $table->integer('vacancies_count')->nullable();
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->date('deadline')->nullable();
            $table->string('external_url')->nullable();
            $table->enum('status', ['draft', 'pending', 'active', 'closed', 'cancelled'])->default('pending');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contests');
    }
};
