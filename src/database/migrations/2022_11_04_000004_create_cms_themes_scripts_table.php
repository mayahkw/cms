<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mayahkw\CMS\database\seeders\ThemeScriptSeeder;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'my_cms_themes_scripts';

    /**
     * Run the migrations.
     * @table cms_themes_scripts
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->unsigned()->index();
            $table->bigInteger('theme_id')->unsigned()->index();
            $table->bigInteger('script_id')->nullable()->unsigned()->index();
            $table->boolean('active')->default(1);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('script_id')->references('id')->on('my_cms_scripts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('theme_id')->references('id')->on('my_cms_themes')->onDelete('cascade')->onUpdate('cascade');
        });

        $seeder = new ThemeScriptSeeder();
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
