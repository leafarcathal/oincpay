<?php

namespace Database\Seeders;
use App\Models\UserGroups;
use Illuminate\Database\Seeder;
use App\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::updateOrCreate([
            'user_group_id' => UserGroups::first()->id,
            'controller'    => 'auth',
            'method'        => 'authenticate',
        ]);

        $permission = Permission::updateOrCreate([
            'user_group_id' => UserGroups::first()->id,
            'controller'    => 'wallet',
            'method'        => 'get',
        ]);

        $permission = Permission::updateOrCreate([
            'user_group_id' => UserGroups::first()->id,
            'controller'    => 'transaction',
            'method'        => 'make',
        ]);

        $permission = Permission::updateOrCreate([
            'user_group_id' => UserGroups::all()[1]->id,
            'controller'    => 'auth',
            'method'        => 'authenticate',
        ]);

        $permission = Permission::updateOrCreate([
            'user_group_id' => UserGroups::all()[1]->id,
            'controller'    => 'wallet',
            'method'        => 'get',
        ]);
    }
}