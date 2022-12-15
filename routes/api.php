<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'checkApi'])->group(function () {
    Route::prefix('my_admin/cms')->group(function () {
        Route::resource("files", FileController::class, ['as' => 'api_my_admin.cms'])->except(["create", "edit", "update"]);
        Route::resource("blocks", BlockController::class, ['as' => 'api_my_admin.cms'])->except(["create", "edit", "update"]);
        Route::resource("paths", PathController::class, ['as' => 'api_my_admin.cms'])->except(["create", "edit", "update"]);
        Route::resource("themes", ThemeController::class, ['as' => 'api_my_admin.cms'])->except(["create", "edit", "update"]);
        Route::prefix('themes')->group(function () {
            Route::resource("blocks", ThemeBlockController::class, ['as' => 'api_my_admin.cms.themes'])->except(["create", "edit", "update"]);
        });
        Route::resource("scripts", ScriptController::class, ['as' => 'api_my_admin.cms'])->except(["create", "edit", "update"]);
    });
});
