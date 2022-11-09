<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mayahkw\CMS\database\seeders\PathLangSeeder;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'cms_paths_langs';

    /**
     * Run the migrations.
     * @table cms_paths_langs
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('path_id')->unsigned()->index();
            $table->string('lang', 5);
            $table->string('path', 150);
            $table->string('full_path', 200);
            $table->boolean('active')->nullable()->default('1');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('path_id')->references('id')->on('cms_paths')->onDelete('no action')->onUpdate('no action');
        });

        $seeder = new PathLangSeeder();
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
