<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@aqdigital.local'],
            [
                'name' => 'AQ Admin',
                'phone' => null,
                'password' => Hash::make('Admin@12345'),
                'is_admin' => true,
                'user_type' => 'superadmin',
                'account_status' => 'active',
                'two_factor_enabled' => false,
            ]
        );

        $defaults = [
            'app_name' => 'AQ Digital & IT Services',
            'app_description' => 'Your trusted partner for innovative digital solutions.',
            'contact_phone' => '+92 346 5090209',
            'contact_email' => 'aqdigitalanditservices2025@gmail.com',
            'contact_address' => 'Barwan Road, Near Tax Office Chakswari, Tehsil & District Mirpur, Azad Kashmir',
            'landing_heading' => 'Your Digital Partner',
            'landing_subheading' => 'Transform your vision into reality with expert IT services and innovative design.',
        ];

        foreach ($defaults as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
