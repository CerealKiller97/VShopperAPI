<?php

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Account::class, 5)->create();
        Account::create([
            'name'      => 'Test Test',
            'email'     => 'test@test.com',
            'password'  => Hash::make('Test1234'),
            'address'   => 'adress',
            'image_id'  => 5
        ]);
    }
}
