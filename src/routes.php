<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Mayahkw\CMS\Controllers\PathController;
use Mayahkw\CMS\Models\CmsPath;

// Comprobar si ya se cuenta con la tabla de rutas 
PathController::index('routes');

//Route::resource("medios", \App\Http\Controllers\v3\CRM\SocioContactoMedioController::class, ['as' => 'v3'])->except(["create", "edit", "show"]);
// rutas api
Route::middleware('auth:sanctum')->prefix('')->group(function () {
    Route::prefix('api')->group(function () {
        // Rutas
    });
});
