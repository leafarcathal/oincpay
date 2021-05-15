<?php

namespace Database\Seeders;

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
        $this->call([
            UserGroupsTableSeeder::class,
            UsersTableSeeder::class,
            WalletTableSeeder::class,
            ApiKeysTableSeeder::class,
            PermissionTableSeeder::class
        ]);
    }
}
