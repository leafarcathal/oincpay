<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\UserGroups;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user = User::updateOrCreate([
            'user_group_id' => UserGroups::first()->id,
            'name'          => 'User 01',
            'email'         => 'user01@yopmail.com',
            'document'      => '95158535086',
            'password'      => Hash::make('123@abcd'),
        ]);

        $user = User::updateOrCreate([
            'user_group_id' => UserGroups::first()->id,
            'name'          => 'User 02',
            'email'         => 'user02@yopmail.com',
            'document'      => '79058748006',
            'password'      => Hash::make('123@abcd'),
        ]);

        $user = User::updateOrCreate([
            'user_group_id' => UserGroups::first()->id,
            'name'          => 'User 03',
            'email'         => 'user03@yopmail.com',
            'document'      => '47643311013',
            'password'      => Hash::make('123@abcd'),
        ]);

        $user = User::updateOrCreate([
            'user_group_id' => UserGroups::all()[1]->id,
            'name'          => 'Store 01',
            'email'         => 'store01@yopmail.com',
            'document'      => '45248720000109',
            'password'      => Hash::make('123@abcd'),
        ]);

        $user = User::updateOrCreate([
            'user_group_id' => UserGroups::all()[1]->id,
            'name'          => 'Store 02',
            'email'         => 'store02@yopmail.com',
            'document'      => '79980333000184',
            'password'      => Hash::make('123@abcd'),
        ]);
    }
}