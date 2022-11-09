<?php

namespace Mayahkw\CMS\database\seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PathSeeder extends Seeder
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
                'theme_id' => 1,
                'domain' => null,
                'lang' => 'es_mx',
                'alias' => 'Home',
                'refresh' => 'yearly',
                'priority' => 1.0,
                'index' => true,
                'home' => 1,
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'theme_id' => 1,
                'domain' => null,
                'lang' => 'es_mx',
                'alias' => 'Demo',
                'refresh' => 'yearly',
                'priority' => 1.0,
                'index' => true,
                'home' => 0,
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('cms_paths')->insert($paths);
    }
}
