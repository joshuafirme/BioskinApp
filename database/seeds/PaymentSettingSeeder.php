<?php

use Illuminate\Database\Seeder;

class PaymentSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('payment_settings')->insert([
            [
                'name' => 'COD',
                'enable_on_retail' => 1,
                'enable_on_rebrand' => 1,
            ],
            [
                'name' => 'Paynamics',
                'enable_on_retail' => 1,
                'enable_on_rebrand' => 1,
            ] 
        ]);
    }
}
