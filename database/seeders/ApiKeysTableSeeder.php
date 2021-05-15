<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Constants\ApiKeyStatusConstant;
use Illuminate\Support\Str;
use App\Models\ApiKey;


class ApiKeysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apiKey = ApiKey::updateOrCreate([
            'user_id' => 1,
            'status'  => ApiKeyStatusConstant::ACTIVE,
            'hash'	  => Str::random(30)
        ]);

        $apiKey = ApiKey::updateOrCreate([
            'user_id' => 2,
            'status'  => ApiKeyStatusConstant::ACTIVE,
            'hash'	  => Str::random(30)
        ]);

        $apiKey = ApiKey::updateOrCreate([
            'user_id' => 3,
            'status'  => ApiKeyStatusConstant::ACTIVE,
            'hash'	  => Str::random(30)
        ]);

        $apiKey = ApiKey::updateOrCreate([
            'user_id' => 4,
            'status'  => ApiKeyStatusConstant::ACTIVE,
            'hash'	  => Str::random(30)
        ]);

        $apiKey = ApiKey::updateOrCreate([
            'user_id' => 5,
            'status'  => ApiKeyStatusConstant::ACTIVE,
            'hash'	  => Str::random(30)
        ]);
    }
}
