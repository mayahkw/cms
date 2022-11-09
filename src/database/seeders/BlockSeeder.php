<?php

namespace Mayahkw\CMS\database\seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BlockSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $paths = [
            [
                'user_id' => 1,
                'order' => 1,
                'use' => 'all',
                'type' => 'container',
                'name' => 'container',
                'description' => 'Contenedor de pagina',
                'options' => '{fluid: true}',
                'operators' => null,
                'value' => '{fluid: true}',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('cms_blocks')->insert($paths);
    }
}
