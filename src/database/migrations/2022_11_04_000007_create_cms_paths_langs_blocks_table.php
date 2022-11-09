<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mayahkw\CMS\database\seeders\PathLangBlockSeeder;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'cms_paths_langs_blocks';

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
            $table->bigInteger('path_lang_id')->unsigned()->index();
            $table->bigInteger('block_id')->unsigned()->index();
            $table->longText('options')->nullable();
            $table->longText('operators')->nullable();
            $table->longText('value');
            $table->boolean('active')->nullable()->default('1');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('path_lang_id')->references('id')->on('cms_paths')->onDelete('no action')->onUpdate('no action');
            $table->foreign('block_id')->references('id')->on('cms_blocks')->onDelete('no action')->onUpdate('no action');
        });

        $seeder = new PathLangBlockSeeder();
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
