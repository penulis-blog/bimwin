<?php

namespace Database\Seeders;

use App\Models\M_sys_users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class sys_usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sys_users')->truncate();

        $data = ['superadmin', 'admin'];

        foreach($data as $value){
            M_sys_users::create([
                'id' => Str::uuid(),
                'username' => $value
            ]);
        }
    }
}
