<?php

namespace Database\Seeders;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$wallet = Wallet::updateOrCreate([
            'user_id' => 1,
            'amount'  => floatval("20,50"),
        ]);

        $wallet = Wallet::updateOrCreate([
            'user_id' => 2,
            'amount'  => floatval('18,34'),
        ]);

        $wallet = Wallet::updateOrCreate([
            'user_id' => 3,
            'amount'  => floatval('238,21'),
        ]);

        $wallet = Wallet::updateOrCreate([
            'user_id' => 4,
            'amount'  => floatval('35,99'),
        ]);

        $wallet = Wallet::updateOrCreate([
            'user_id' => 5,
            'amount'  => floatval('67,90'),
        ]);
    }
}