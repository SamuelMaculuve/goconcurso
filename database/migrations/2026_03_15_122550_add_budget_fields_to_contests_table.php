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
        Schema::table('contests', function (Blueprint $table) {
            $table->decimal('budget_min', 15, 2)->nullable()->after('salary_max');
            $table->decimal('budget_max', 15, 2)->nullable()->after('budget_min');
            $table->string('budget_currency', 10)->default('USD')->after('budget_max');
        });
    }

    public function down(): void
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->dropColumn(['budget_min', 'budget_max', 'budget_currency']);
        });
    }
};
