<?php

namespace Mayahkw\CMS\database\seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ThemeScriptSeeder extends Seeder
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
                'theme_id' => 1,
                'script_id' => 1,
            ],
        ];

        DB::table('cms_themes_scripts')->insert($themes);
    }
}
