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
    public $tableName = 'my_cms_blocks_scripts';

    /**
     * Run the migrations.
     * @table cms_blocks_scripts
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('block_id')->unsigned()->index();
            $table->bigInteger('script_id')->unsigned()->index();
            $table->bigInteger('parent_id')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('script_id')->references('id')->on('my_cms_scripts')->onDelete('no action')->onUpdate('no action');
            $table->foreign('block_id')->references('id')->on('my_cms_blocks')->onDelete('no action')->onUpdate('no action');
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
