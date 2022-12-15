<?php

namespace Mayahkw\CMS\database\seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PathLangSeeder extends Seeder
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
                'path_id' => 1,
                'theme_id' => 1,
                'lang' => 'es_mx',
                'path' => '/',
                'full_path' => '/es_mx',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'path_id' => 1,
                'theme_id' => 2,
                'lang' => 'en_us',
                'path' => '/',
                'full_path' => '/en_us',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'path_id' => 2,
                'theme_id' => 1,
                'lang' => 'es_mx',
                'path' => '/demo',
                'full_path' => '/es_mx/demo',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'path_id' => 2,
                'theme_id' => 2,
                'lang' => 'en_us',
                'path' => '/demo',
                'full_path' => '/en_us/demo',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('my_cms_paths_langs')->insert($paths);
    }
}
