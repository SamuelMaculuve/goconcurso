<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('country')->nullable()->after('bio');
            $table->string('city')->nullable()->after('country');
            $table->string('professional_area')->nullable()->after('city');
            $table->string('cv_path')->nullable()->after('professional_area');
            $table->enum('role_type', ['super-admin', 'company', 'advertiser', 'candidate'])->default('candidate')->after('cv_path');
            $table->boolean('is_active')->default(true)->after('role_type');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'avatar',
                'bio',
                'country',
                'city',
                'professional_area',
                'cv_path',
                'role_type',
                'is_active',
            ]);
        });
    }
};
