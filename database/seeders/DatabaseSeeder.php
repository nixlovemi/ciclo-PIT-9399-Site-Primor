<?php

namespace Database\Seeders;

use App\Models\User;
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
        $this->UserSeed();
    }

    private function UserSeed(): void
    {
        foreach(array_keys(User::USER_ROLES) as $role) {
            foreach([true, false] as $active) {
                User::factory(1)->create([
                    'role' => $role,
                    'active' => $active,
                ]);
            }
        }
    }
}
