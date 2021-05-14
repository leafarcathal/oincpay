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
        $userGroup = new UserGroups();
        $userGroup->name = 'Royal';
        $userGroup->save();

        $userGroup = new UserGroups();
        $userGroup->name = 'Store';
        $userGroup->save();
    }
}
