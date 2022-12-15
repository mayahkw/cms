<?php

namespace Mayahkw\CMS\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Mayahkw\Admin\Facades\MyAdmin;
use Mayahkw\CMS\Models\CmsPath;
use Mayahkw\CMS\Models\CmsPathLang;

class PathController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $paths = [];
        if (Schema::hasTable('my_cms_paths')) {
            $paths = CmsPath::where('alias', 'like', '%' . request()->search . '%')->paginate(15);
            foreach ($paths as $path) {
                foreach ($path->langs as $lang) {
                    /* if (!is_null($lang->theme)) {
                        $lang->theme->scripts;
                        $lang->theme->blocks;
                    }*/
                    foreach ($lang->blocks as $dataB) {
                        $dataB->block->scripts;
                    }
                }
                $path->theme;
            }
        }

        if (Route::currentRouteName() == 'api_my_admin.cms.paths.index') {
            // Cargar lista de rutas
            if (request()->use == 'routes') {
                if (Schema::hasTable('my_cms_paths')) {
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
            if (request()->use == 'sitemap') {
            }

            return $paths;
        }

        return MyAdmin::page();
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
