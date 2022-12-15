<?php

namespace Mayahkw\CMS\database\seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ThemeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $themes = [
            [
                'user_id' => 1,
                'lang' => 'es_mx',
                'name' => 'default',
                'description' => 'Tema default de inicio para la pagina web',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'lang' => 'en_us',
                'name' => 'default',
                'description' => 'Tema default de inicio para la pagina web',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('my_cms_themes')->insert($themes);
    }
}
