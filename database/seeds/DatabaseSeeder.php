<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ImageTableSeeder::class);
        $this->call(AccountTableSeeder::class);
        // $this->call(StorageTypeSeeder::class);

    }
}
