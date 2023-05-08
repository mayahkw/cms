<?php

namespace Mayahkw\CMS\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use Mayahkw\Admin\Facades\MyAdmin;
use Mayahkw\CMS\Facades\MyCms;
use Mayahkw\CMS\Models\CmsPath;
use Mayahkw\CMS\Models\CmsPathLang;
use PhpParser\Node\Expr\Cast\Object_;

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
                    $path->index = $path->index == 1 ? true : false;
                    $path->home = $path->home == 1 ? true : false;
                    /* if (!is_null($lang->theme)) {
                        $lang->theme->scripts;
                        $lang->theme->blocks;
                    }*/
                    foreach ($lang->blocks as $dataB) {
                        $dataB->block->scripts;
                    }
                }
                $path->public_at = ($path->public_at != null ? Carbon::parse($path->public_at)->format('d-m-Y H:m') : null);
                $path->disabled_at = ($path->disabled_at != null ? Carbon::parse($path->disabled_at)->format('d-m-Y H:m') : null);
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
        $view = CmsPathLang::find($id);
        $view->page;
        $view->theme;
        $view->page->langs;

        $view->render = MyCms::getTheme($view->theme->id);

        $system = [
            'config' => [
                'site' => [
                    'value' => 'Mays'
                ]
            ],
        ];

        if (Auth::check() and isset(request()->edit)) {
            // Mostrar edicion de pagina
            //return Inertia::render('My/Cms/Components/Render', $view);
            return MyAdmin::page($view, 'My/Cms/Components/Render');
        } else {
            // Mostrar pagina 
            return view(
                'my_cms::view',
                [
                    'blocks' => $view->render->blocks,
                    'data' => $view,
                    'system' => json_decode(json_encode($system))
                ]
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsPath
     * @return \Illuminate\Http\Response
     */
    public function edit($data)
    {
        // dd($data);
        if (isset($data['id'])) {
            if ($data['id'] == -1) {
                $path = new CmsPath();
                $path->user_id = Auth::user()->id;
            } else {
                $path = CmsPath::find($data['id']);
            }
            $path->domain = '';
            $path->alias = $data['alias'];
            $path->refresh = $data['refresh'];
            $path->priority = $data['priority'];
            if ($data['home'] == true or $data['home'] == 1) {
                $oldHome = CmsPath::where('home', 1)->get();
                foreach ($oldHome as $old) {
                    $old->home = 0;
                    $old->save();
                }

                $path->index = $data['index'];
            }
            $path->home = $data['home'];
            $path->program_public = $data['program_public'];
            $path->public_at = Carbon::parse($data['public_at'])->format('Y-m-d H:m');
            $path->program_disabled = $data['program_disabled'];
            $path->disabled_at = Carbon::parse($data['disabled_at'])->format('Y-m-d H:m');
            $path->active = $data['active'];
            $path->save();

            foreach ($data['langs'] as $lang) {
                if ($data['id'] == -1) {
                    $pathLangs = new CmsPathLang();
                    $pathLangs->user_id = Auth::user()->id;
                } else {
                    $pathLangs = CmsPathLang::where('path_id', $path->id)->where('lang', $lang['lang'])->first();
                    if (!$pathLangs) {
                        $pathLangs = new CmsPathLang();
                        $pathLangs->user_id = Auth::user()->id;
                    }
                }
                $pathLangs->path_id = $path->id;
                $pathLangs->theme_id = $lang['theme_id'];
                $pathLangs->lang = $lang['lang'];
                $pathLangs->title = $lang['title'];
                $pathLangs->path = $lang['path'];
                $pathLangs->full_path = $lang['full_path'];
                $pathLangs->active = 1;
                $pathLangs->save();
            }
            $path->langs;
        }

        return $path;
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
