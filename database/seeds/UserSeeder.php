<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            [
                'firstname' => 'Fahm',
                'lastname' => 'Basari',
                'email' => 'bioskin1a@yahoo.com',
                'phone_no' => '90000000',
                'username' => 'bioskin',
                'password' => \Hash::make('tXPGm3mwEaHYGQrC'),
                'access_rights' => 1,
                'status' => 1
            ] 
        ]);
    }
}
