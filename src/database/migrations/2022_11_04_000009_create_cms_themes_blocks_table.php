<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'cms_themes_blocks';

    /**
     * Run the migrations.
     * @table cms_themes_blocks
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('theme_id')->unsigned()->index();
            $table->bigInteger('block_id')->unsigned()->index();
            $table->integer('order');
            $table->string('lang', 5);
            $table->longText('options')->nullable();
            $table->longText('operators')->nullable();
            $table->longText('value');
            $table->boolean('active')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('theme_id')->references('id')->on('cms_themes')->onDelete('no action')->onUpdate('no action');
            $table->foreign('block_id')->references('id')->on('cms_blocks')->onDelete('no action')->onUpdate('no action');
        });
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
