<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => bcrypt('mantapjiwa00')
        ]);

        \App\Models\User::create([
            'name' => 'Linda',
            'email' => 'linda@admin.com',
            'password' => bcrypt('mantapjiwa00')
        ]);

        \App\Models\User::create([
            'name' => 'Sherly',
            'email' => 'sherly@admin.com',
            'password' => bcrypt('mantapjiwa00')
        ]);

        \App\Models\User::create([
            'name' => 'Juli',
            'email' => 'juli@admin.com',
            'password' => bcrypt('mantapjiwa00')
        ]);

        \App\Models\PaymentWay::create([
            'payment_way' => 'VA',
        ]);

        \App\Models\PaymentWay::create([
            'payment_way' => 'EDC Mandiri',
        ]);

        \App\Models\PaymentWay::create([
            'payment_way' => 'EDC BCA',
        ]);

        \App\Models\SchoolLevel::create([
            'school_level' => 'SD - Kelas 1',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SD - Kelas 2',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SD - Kelas 3',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SD - Kelas 4',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SD - Kelas 5',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SD - Kelas 6',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SMP - Kelas 1',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SMP - Kelas 2',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SMP - Kelas 3',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SMA - Kelas 1',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SMA - Kelas 2',
        ]);
        \App\Models\SchoolLevel::create([
            'school_level' => 'SMA - Kelas 3',
        ]);

        \App\Models\Setting::create([
            'meta_key' => 'is_fine_of_amount_active',
            'meta_value' => 0,
        ]);

        \App\Models\SchoolYear::create([
            'school_year_name' => '2022/2023',
            'school_year_start' => 2022,
            'school_year_end' => 2023,
            'date_of_fine' => 20,
            'fine_amount' => 5000,
            'is_active' => 1
        ]);

        \App\Models\SppMaster::create([
            'spp_name' => 'SPP Umum',
            'amount' => 600000
        ]);

        \App\Models\Teacher::create([
            'teacher_name' => 'Parlan'
        ]);

        \App\Models\Classroom::create([
            'school_level_id' => 1,
            'classroom_name' => 'Matthew 1',
            // 'teacher_id' => 1
        ]);

        \App\Models\TeacherClassroom::create([
            'classroom_id' => 1,
            'school_year_id' => 1,
            'teacher_id' => 1
        ]);

        
    }
}
