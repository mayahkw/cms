<?php

namespace Mayahkw\CMS\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Mayahkw\CMS\Models\CmsPath;
use Mayahkw\CMS\Models\CmsPathLang;

class PathController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($use)
    {
        // Cargar lista de rutas
        if ($use == 'routes') {
            if (Schema::hasTable('cms_paths')) {
                // Cargar las rutas
                $paths = CmsPath::where('active', 1)->get();
                if (count($paths) > 0) {
                    foreach ($paths as $path) {
                        $path->langs;
                        if (is_null($path->diabled_at) and is_null($path->deleted_at)) {
                            foreach ($path->langs as $lang) {
                                Route::get($path->home ? ($path->lang === $lang->lang ? '/' : $lang->full_path) : $lang->full_path, [PathController::class, 'show'])->name('id_' . $lang->id);
                            }
                        } else {
                            if (!is_null($path->public_at) and Carbon::parse($path->public_at) >= Carbon::now() and (is_null($path->deleted_at) or Carbon::parse($path->deleted_at) <= Carbon::now())) {
                                foreach ($path->langs as $lang) {
                                    Route::get($path->home ? ($path->lang === $lang->lang ? '/' : $lang->full_path) : $lang->full_path, [PathController::class, 'show'])->name('id_' . $lang->id);
                                }
                            }
                        }
                    }
                }
            }
        }

        // Site Map XML
        if ($use == 'sitemap') {
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsPath
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = ((int) substr(Route::currentRouteName(), 3));
        $lang = CmsPathLang::find($id);
        $lang->page->theme;
        $lang->page->langs;

        return $lang;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsPath
     * @return \Illuminate\Http\Response
     */
    public function edit($data)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->edit(request()->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Mayahkw\CMS\Models\CmsPath
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CmsPath $path)
    {
        return $this->edit(request()->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Mayahkw\CMS\Models\CmsPath
     * @return \Illuminate\Http\Response
     */
    public function destroy(CmsPath $path)
    {
        //
    }
}
