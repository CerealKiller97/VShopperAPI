<?php

use App\Models\Unit;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;


class UnitTableSeeder extends Seeder
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
                'name' => 'Kilogram',
                'abbr' => 'kg',
                'account_id' => null
            ],
            [
                'name' => 'Piece',
                'abbr' => 'pc.',
                'account_id' => null
            ]
        ];

        foreach($data as $unit)
        {
            Unit::create($unit);
        }
    }
}
