<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::create(Role::RoleName);

        $users = User::where("type", 'admin')->get();
        foreach ($users as $user) {
            $user = \App\Models\User::find(1);
            $user->roles()->save(\App\Models\Role::find(1));
        }
    }
}
