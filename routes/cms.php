<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Mayahkw\CMS\Controllers\PathController;
use Illuminate\Support\Facades\Schema;
use Mayahkw\CMS\Models\CmsPath;

// Comprobar si ya se cuenta con la tabla de rutas 
if (Schema::hasTable('my_cms_paths')) {
    // Cargar las rutas
    $paths = CmsPath::where('active', 1)->orderby('home', 'desc')->get();
    //dd($paths);
    if (count($paths) > 0) {
        foreach ($paths as $path) {
            $path->langs;
            if (is_null($path->deleted_at)) {
                if (($path->program_public == 0 or Carbon::parse($path->public_at) >= Carbon::now()) and ($path->program_disabled == 0 or Carbon::parse($path->disabled_at) <= Carbon::now())) {
                    // dd((is_null($path->public_at) or Carbon::parse($path->public_at) >= Carbon::now()) and (is_null($path->deleted_at) or Carbon::parse($path->deleted_at) <= Carbon::now()));
                    foreach ($path->langs as $lang) {
                        Route::get(($path->home == 1 ? '/' : $lang->full_path), [PathController::class, 'show'])->name('id_' . $lang->id);
                    }
                }
            }
        }
    }
}
