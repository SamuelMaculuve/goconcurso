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
        Schema::table('contest_applications', function (Blueprint $table) {
            $table->text('solution_description')->nullable()->after('cover_letter');
            $table->decimal('proposed_value', 15, 2)->nullable()->after('solution_description');
            $table->string('currency', 10)->default('USD')->after('proposed_value');
        });
    }

    public function down(): void
    {
        Schema::table('contest_applications', function (Blueprint $table) {
            $table->dropColumn(['solution_description', 'proposed_value', 'currency']);
        });
    }
};
