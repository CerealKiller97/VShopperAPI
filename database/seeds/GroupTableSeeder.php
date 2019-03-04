<?php

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Subscribers'
            ],
            [
                'name' => 'Premium users'
            ]
        ];

        foreach($data as $item)
        {
            Group::create($item);
        }
    }
}
