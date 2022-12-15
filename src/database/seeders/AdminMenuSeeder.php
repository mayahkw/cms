<?php

namespace Mayahkw\CMS\database\seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AdminMenuSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $values_config = [
            [
                'user_id' => 1,
                'menu_id' => null,
                'order' => 1,
                'type' => 'Menu',
                'title' => '[{"lang":"es_mx", "value":"CMS"},{"lang":"en_us", "value":"CMS"}]',
                'icon' => 'web',
                'href' => 'my_admin.config.index',
                'params' => null,
                'teams' => null,
                'users' => '[1]',
                'not_users' => null,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'menu_id' => 5,
                'order' => 1,
                'type' => 'Route',
                'title' => '[{"lang":"es_mx", "value":"Paginas"},{"lang":"en_us", "value":"Pages"}]',
                'icon' => 'text-box-outline',
                'href' => 'my_admin.cms.paths.index',
                'params' => null,
                'teams' => null,
                'users' => null,
                'not_users' => null,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'menu_id' => 5,
                'order' => 1,
                'type' => 'Route',
                'title' => '[{"lang":"es_mx", "value":"Temas"},{"lang":"en_us", "value":"Themes"}]',
                'icon' => 'drama-masks',
                'href' => 'my_admin.cms.themes.index',
                'params' => null,
                'teams' => null,
                'users' => null,
                'not_users' => null,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'menu_id' => 5,
                'order' => 1,
                'type' => 'Route',
                'title' => '[{"lang":"es_mx", "value":"Bloques"},{"lang":"en_us", "value":"Blocks"}]',
                'icon' => 'puzzle',
                'href' => 'my_admin.cms.blocks.index',
                'params' => null,
                'teams' => null,
                'users' => null,
                'not_users' => null,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('my_admin_menus')->insert($values_config);
    }
}
