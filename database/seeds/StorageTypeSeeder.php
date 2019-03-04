<?php

use Illuminate\Database\Seeder;

class StorageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storage_types = [
            'server',
            'hangar'
        ];
        foreach($storage_types as $type)
        {
            DB::table('storage_types')->insert([
                'label' => $type,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
