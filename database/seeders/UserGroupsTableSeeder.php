<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\UserGroups;

class UserGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userGroup = UserGroups::updateOrCreate([
            'name'          => 'Royal'
        ]);

        $userGroup = UserGroups::updateOrCreate([
            'name'          => 'Store'
        ]);
    }
}
