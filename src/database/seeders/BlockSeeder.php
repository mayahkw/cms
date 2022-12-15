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
                'name' => 'Contenedor',
                'description' => 'Contenedor de pagina',
                'options' => '{ "class": [ { "name": "Contenedor", "type": "select", "multiple": false, "values": [ "container", "container-sm", "container-md", "container-lg", "container-xl", "container-xxl", "container-fluid" ], "default": "container" } ], "styles": [ { "name": "background-color", "type": "color-picker", "multiple": false, "values": [], "default": "#246F0F" }, { "name": "color", "type": "color-picker", "multiple": false, "values": [], "default": "#F7F5F5" }, { "name": "font-size", "type": "text", "multiple": false, "values": [], "default": "20px" } ], "father": { "value": true, "limit": "0", "content": false } }',
                'operators' => null,
                'value' => null,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'order' => 1,
                'use' => 'all',
                'type' => 'row',
                'name' => 'Filas',
                'description' => 'Contenedor de pagina',
                'options' => '{ "class": [ { "name": "Max col default", "type": "select", "multiple": false, "values": [ "row-cols-1", "row-cols-2", "row-cols-3", "row-cols-4", "row-cols-5", "row-cols-6", "row-cols-7", "row-cols-8", "row-cols-9", "row-cols-10", "row-cols-11", "row-cols-12", "row" ], "default": null }, { "name": "Max col default sm", "type": "select", "multiple": false, "values": [ "row-cols-sm-1", "row-cols-sm-2", "row-cols-sm-3", "row-cols-sm-4", "row-cols-sm-5", "row-cols-sm-6", "row-cols-sm-7", "row-cols-sm-8", "row-cols-sm-9", "row-cols-sm-10", "row-cols-sm-11", "row-cols-sm-12", "row" ], "default": null }, { "name": "Max col default md", "type": "select", "multiple": false, "values": [ "row-cols-md-1", "row-cols-md-2", "row-cols-md-3", "row-cols-md-4", "row-cols-md-5", "row-cols-md-6", "row-cols-md-7", "row-cols-md-8", "row-cols-md-9", "row-cols-md-10", "row-cols-md-11", "row-cols-md-12", "row" ], "default": null }, { "name": "Max col default lg", "type": "select", "multiple": false, "values": [ "row-cols-lg-1", "row-cols-lg-2", "row-cols-lg-3", "row-cols-lg-4", "row-cols-lg-5", "row-cols-lg-6", "row-cols-lg-7", "row-cols-lg-8", "row-cols-lg-9", "row-cols-lg-10", "row-cols-lg-11", "row-cols-lg-12", "row" ], "default": [] } ], "styles": [ { "name": "background-color", "type": "color-picker", "multiple": false, "values": [], "default": "#246F0F" }, { "name": "color", "type": "color-picker", "multiple": false, "values": [], "default": "#F7F5F5" }, { "name": "font-size", "type": "text", "multiple": false, "values": [], "default": "10px" } ], "father": { "value": true, "limit": null, "content": false } }',
                'operators' => null,
                'value' => null,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'order' => 1,
                'use' => 'all',
                'type' => 'cols',
                'name' => 'Columnas',
                'description' => 'Contenedor de pagina',
                'options' => '{ "class": [ { "name": "Columnas default", "type": "select", "multiple": false, "values": [ "col", "col-1", "col-2", "col-3", "col-4", "col-5", "col-6", "col-7", "col-8", "col-9", "col-10", "col-11", "col-12" ], "default": null }, { "name": "Columnas pantalla mediana", "type": "select", "multiple": false, "values": [ "col-sm", "col-sm-1", "col-sm-2", "col-sm-3", "col-sm-4", "col-sm-5", "col-sm-6", "col-sm-7", "col-sm-8", "col-sm-9", "col-sm-10", "col-sm-11", "col-sm-12" ], "default": [ null ] }, { "name": "Columnas pantalla grande", "type": "select", "multiple": false, "values": [ "col-lg", "col-lg-1", "col-lg-2", "col-lg-3", "col-lg-4", "col-lg-5", "col-lg-6", "col-lg-7", "col-lg-8", "col-lg-9", "col-lg-10", "col-lg-11", "col-lg-12" ], "default": null } ], "styles": [ { "name": "background-color", "type": "color-picker", "multiple": false, "values": [], "default": "#246F0F" }, { "name": "color", "type": "color-picker", "multiple": false, "values": [], "default": "#F7F5F5" }, { "name": "font-size", "type": "text", "multiple": false, "values": [], "default": "10px" } ], "father": { "value": true, "limit": null, "content": false } }',
                'operators' => null,
                'value' => '',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'order' => 1,
                'use' => 'all',
                'type' => 'img',
                'name' => 'Imagen',
                'description' => 'Imagen',
                'options' => '{ "class": [ { "name": "Distribuicion de imagen", "type": "select", "multiple": true, "values": [ "img-fluid", "img-thumbnail", "rounded" ], "default": null }, { "name": "Posicion de imagen", "type": "select", "multiple": false, "values": [ "float-start", "float-end" ], "default": null } ], "styles": [], "father": { "value": false, "limit": null, "content": true } }',
                'operators' => null,
                'value' => null,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'order' => 1,
                'use' => 'all',
                'type' => 'carousel',
                'name' => 'Slider',
                'description' => 'Slider de imagenes',
                'options' => '{ "class": [ { "name": "Tipo de carousel", "type": "select", "multiple": false, "values": [ "carousel slide", "carousel slide carousel-fade", "carousel carousel-dark slide" ], "default": null } ], "styles": [], "father": { "value": false, "limit": null, "content": true } }',
                'operators' => null,
                'value' => null,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'order' => 1,
                'use' => 'all',
                'type' => 'title',
                'name' => 'Titulo',
                'description' => 'Titulo',
                'options' => '{ "class": [ { "name": "Nivel", "type": "select", "multiple": false, "values": [ "h1", "h2", "h3", "h4", "h5", "h6" ], "default": null }, { "name": "Alineacion Default", "type": "select", "multiple": false, "values": [ "text-start", "text-center", "text-end" ], "default": null }, { "name": "Alineación small", "type": "select", "multiple": false, "values": [ "text-sm-start", "text-sm-center", "text-sm-end" ], "default": null }, { "name": "Alineación med", "type": "select", "multiple": false, "values": [ "text-md-start", "text-md-center", "text-md-end" ], "default": null }, { "name": "Alineacion large", "type": "select", "multiple": false, "values": [ "text-lg-start", "text-lg-center", "text-lg-end" ], "default": null } ], "styles": [ { "name": "color", "type": "color-picker", "multiple": false, "values": [], "default": "#000000" } ], "father": { "value": false, "limit": null, "content": true } }',
                'operators' => null,
                'value' => '',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'order' => 1,
                'use' => 'all',
                'type' => 'content',
                'name' => 'Contenido',
                'description' => 'Contenido',
                'options' => '{ "class": [], "styles": [ { "name": "font-size", "type": "text", "multiple": false, "values": [], "default": "1em" }, { "name": "color", "type": "color-picker", "multiple": false, "values": [], "default": "#000000" }, { "name": "background-color", "type": "color-picker", "multiple": false, "values": [], "default": "#FFFFFF" } ], "father": { "value": false, "limit": null, "content": true } }',
                'operators' => null,
                'value' => '',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('my_cms_blocks')->insert($paths);
    }
}
