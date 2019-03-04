<?php

use App\Models\StorageType;
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
            ['name' => 'server'],
            ['name' => 'hangar']
        ];

        foreach ($storage_types as $storageType)
        {
            StorageType::create($storageType);
        }
    }
}
