<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mayahkw\CMS\database\seeders\BlockSeeder;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'cms_blocks';

    /**
     * Run the migrations.
     * @table cms_blocks
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->integer('order');
            $table->string('use', 50)->comment('Tipo de uso theme, path, all');
            $table->string('type', 20)->comment('Tipos de bloques que se pueden usar Sliders, listas, ');
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->longText('options')->nullable();
            $table->longText('operators')->nullable();
            $table->longText('value');
            $table->boolean('active')->default('1')->comment(' El bloque esta activo');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        $seeder = new BlockSeeder();
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
