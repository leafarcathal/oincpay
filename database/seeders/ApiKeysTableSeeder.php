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
            'hash'	  => 'mLgeVH4aYah0O6y2TqZlwkinGqXBRn' // Should be Str::random(30), it is static now just to make it easier to provide API documentation
        ]);

        $apiKey = ApiKey::updateOrCreate([
            'user_id' => 2,
            'status'  => ApiKeyStatusConstant::ACTIVE,
            'hash'	  => 'SnuaSUD32Ay0esYgI4o08bsZWtlOj7' // Should be Str::random(30), it is static now just to make it easier to provide API documentationStr::random(30)
        ]);

        $apiKey = ApiKey::updateOrCreate([
            'user_id' => 3,
            'status'  => ApiKeyStatusConstant::ACTIVE,
            'hash'	  => 'HIZ0fgGzP2RoaI0GpvhHo4RbIrq9m3' // Should be Str::random(30), it is static now just to make it easier to provide API documentationStr::random(30)
        ]);

        $apiKey = ApiKey::updateOrCreate([
            'user_id' => 4,
            'status'  => ApiKeyStatusConstant::ACTIVE,
            'hash'	  => 'UsWWWfDuhwIvrGepd4sxvsVcRsF5Ig' // Should be Str::random(30), it is static now just to make it easier to provide API documentationStr::random(30)
        ]);

        $apiKey = ApiKey::updateOrCreate([
            'user_id' => 5,
            'status'  => ApiKeyStatusConstant::ACTIVE,
            'hash'	  => 'gqZBymbN2dVJZ71Tll5vm6S74LKfxz' // Should be Str::random(30), it is static now just to make it easier to provide API documentationStr::random(30)
        ]);
    }
}
