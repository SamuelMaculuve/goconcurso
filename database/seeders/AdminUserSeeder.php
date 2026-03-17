<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Plan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@goconcursos.ao'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make('password'),
                'role_type' => 'super-admin',
                'is_active' => true,
            ]
        );
        $admin->assignRole('super-admin');

        // Demo Company User
        $companyUser = User::updateOrCreate(
            ['email' => 'empresa@demo.ao'],
            [
                'name'      => 'Demo Empresa',
                'password'  => Hash::make('password'),
                'role_type' => 'company',
                'is_active' => true,
            ]
        );
        $companyUser->assignRole('company');

        // Demo Company Profile
        $freePlan = Plan::where('slug', 'gratuito')->first();
        Company::updateOrCreate(
            ['user_id' => $companyUser->id],
            [
                'name'         => 'Empresa Demo Lda',
                'slug'         => 'empresa-demo-lda',
                'description'  => 'Empresa de demonstração para testes da plataforma GoConcursos.',
                'email'        => 'empresa@demo.ao',
                'country'      => 'Angola',
                'city'         => 'Luanda',
                'company_type' => 'private',
                'plan_id'      => $freePlan?->id,
                'is_verified'  => true,
                'is_active'    => true,
            ]
        );

        // Demo Candidate
        $candidate = User::updateOrCreate(
            ['email' => 'candidato@demo.ao'],
            [
                'name'              => 'João Candidato',
                'password'          => Hash::make('password'),
                'role_type'         => 'candidate',
                'country'           => 'Angola',
                'city'              => 'Luanda',
                'professional_area' => 'Tecnologia',
                'is_active'         => true,
            ]
        );
        $candidate->assignRole('candidate');
    }
}
