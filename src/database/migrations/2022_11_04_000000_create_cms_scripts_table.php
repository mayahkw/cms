<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mayahkw\CMS\database\seeders\ScriptSeeder;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'cms_scripts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->unsigned()->index();
            $table->string('name', 30)->comment('Nombre de la libreria o script');
            $table->string('type', 30)->comment('Css JS CDN');
            $table->string('script', 30)->comment('java o css');
            $table->string('use', 45)->default('theme')->comment('Tipo de uso en Template, Block, all');
            $table->longText('value')->comment('URL de CDN o script');
            $table->boolean('active')->default('1')->comment('Css JS CDN');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        if (count(User::get()) == 0) {
            \App\Models\User::factory(10)->withPersonalTeam()->create();
            /*
            \App\Models\User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => '$2y$10$xItK1AThlyP9WkDLabLSHe1MQ5FmrwGy9fs0nuB0E8hID3s0Ae8Eu'
            ]);
            */
        }

        $seeder = new ScriptSeeder();
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
