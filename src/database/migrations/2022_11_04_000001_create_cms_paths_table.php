<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mayahkw\CMS\database\seeders\PathSeeder;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'my_cms_paths';

    /**
     * Run the migrations.
     * @table cms_paths
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('domain', 100)->nullable();
            $table->string('lang', 5)->nullable()->comment('Idioma por default de la pagina');
            $table->string('alias', 45)->nullable()->comment('Aalias de la ruta debe de ser unica');
            $table->string('refresh', 10)->nullable()->comment('Tiempo de refresco para in sitemap \'daily, yearly, never\'');
            $table->float('priority')->nullable()->comment('Prioridad de la pagina para sitemap del 0 al 1');
            $table->tinyInteger('index')->nullable()->default('1')->comment('Aparece en sitemap');
            $table->boolean('home')->nullable()->default(0)->comment('Estblecer pagina de inicio');
            $table->boolean('program_public')->default('0')->comment('La pagina esta programada para publicarse');
            $table->dateTime('public_at')->nullable()->comment('Programacion de fecha de publicacion de la URL');
            $table->boolean('program_disabled')->default('0')->comment('La pagina esta programada para retirce de la publicacion');
            $table->dateTime('disabled_at')->nullable()->comment('Programacion de fecha de baja de contenido');
            $table->boolean('active')->nullable()->default('1')->comment('La pagina esta activa o no');
            $table->softDeletes();
            $table->timestamps();


            $table->unique(["alias"], 'alias_UNIQUE');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        $seeder = new PathSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
};
