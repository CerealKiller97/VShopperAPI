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
                'name' => 'Subscribers',
                'account_id' => 1
            ],
            [
                'name' => 'Premium users',
                'account_id' => 2
            ]
        ];

        foreach($data as $item)
        {
            Group::create($item);
        }
    }
}
