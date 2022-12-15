<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Mayahkw\CMS\Controllers\PathController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

// Comprobar si ya se cuenta con la tabla de rutas 
PathController::index('routes');


// Rutas
Route::prefix('cms')->group(function () {
    Route::resource("files", FileController::class, ['as' => 'my_admin.cms'])->except(["create", "edit", "update", "store", "destroy"]);
    Route::resource("blocks", BlockController::class, ['as' => 'my_admin.cms'])->except(["create", "edit", "update", "store", "destroy"]);
    Route::resource("paths", PathController::class, ['as' => 'my_admin.cms'])->except(["create", "edit", "update", "store", "destroy"]);
    Route::resource("themes", ThemeController::class, ['as' => 'my_admin.cms'])->except(["create", "edit", "update", "store", "destroy"]);
    Route::resource("scripts", ScriptController::class, ['as' => 'my_admin.cms'])->except(["create", "edit", "update", "store", "destroy"]);
});
