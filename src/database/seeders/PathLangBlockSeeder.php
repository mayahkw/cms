<?php

namespace Mayahkw\CMS\database\seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PathLangBlockSeeder extends Seeder
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
                'path_lang_id' => 1,
                'block_id' => 1,
                'options' => 'sadf',
                'operators' => 'sadf',
                'value' => 'test',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('my_cms_paths_langs_blocks')->insert($paths);
    }
}
