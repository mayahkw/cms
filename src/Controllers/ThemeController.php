<?php

namespace Mayahkw\CMS\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Mayahkw\Admin\Facades\MyAdmin;
use Mayahkw\CMS\Facades\MyCms;
use Mayahkw\CMS\Models\CmsPath;
use Mayahkw\CMS\Models\CmsTheme;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $themes = CmsTheme::where('active', 1)->wherenull('deleted_at')->paginate(15);
        foreach ($themes as $theme) {
            $theme->blocks = MyCms::getBlocks($theme->id, null);
        }

        if (Route::currentRouteName() == 'api_my_admin.cms.themes.index') {
            return $themes;
        }

        return MyAdmin::page();
    }

    /**
     * Display the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsPath
     * @return \Illuminate\Http\Response
     */
    public function show(CmsTheme $theme)
    {
        if (Route::currentRouteName() == 'api_my_admin.cms.themes.show') {
            $return = MyCms::getTheme($theme->id);
            return $return;
        }

        return MyAdmin::page();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsPath
     * @return \Illuminate\Http\Response
     */
    public function edit($data)
    {
        if ($data['id'] == -1) {
            $theme = new CmsTheme();
            $theme->user_id = Auth::user()->id;
        } else {
            $theme = CmsTheme::find($data['id']);
        }
        !isset($data['name']) ?: $theme->name = $data['name'];
        !isset($data['description']) ?: $theme->description = $data['description'];
        $theme->save();

        return $theme;
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
    public function update(Request $request, CmsTheme $theme)
    {
        return $this->edit(request()->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Mayahkw\CMS\Models\CmsPath
     * @return \Illuminate\Http\Response
     */
    public function destroy(CmsTheme $theme)
    {
        if (count($theme->blocks) > 0 or count($theme->langs) > 0) {
            $theme->active = 0;
            $theme->deleted_at = Carbon::now();
            $theme->save();
            return $theme;
        } else {
            $theme->delete();
            return 'delete';
        }
    }
}
