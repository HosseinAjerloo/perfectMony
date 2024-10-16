<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Doller;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (Doller::Dollers as $doller)
        {
            Doller::create($doller);
        }

        foreach (Service::Services as $service)
        {
            Service::create($service);
        }
        foreach (Bank::Banks as $bank)
        {
            Bank::create($bank);
        }
        User::create(User::users);

        $this->call(RoleSeeder::class);
    }
}
