<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Developer::create(
            [
                'id' => 1,
                'name' => 'Dev1',
                'time' => 1,
                'level' => 1,
            ]
        );
        Developer::create(
            [
                'id' => 2,
                'name' => 'Dev2',
                'time' => 1,
                'level' => 2,
            ]
        );
        Developer::create(
            [
                'id' => 3,
                'name' => 'Dev3',
                'time' => 1,
                'level' => 3,
            ]
        );
        Developer::create(
            [
                'id' => 4,
                'name' => 'Dev4',
                'time' => 1,
                'level' => 4,
            ]
        );
        Developer::create(
            [
                'id' => 5,
                'name' => 'Dev5',
                'time' => 1,
                'level' => 5,
            ]
        );

    }
}
