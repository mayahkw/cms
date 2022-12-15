<?php

namespace Mayahkw\CMS\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Mayahkw\Admin\Facades\MyAdmin;
use Mayahkw\CMS\Models\CmsPath;
use Mayahkw\CMS\Models\CmsPathLang;

class ScriptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($use)
    {
        if (Route::currentRouteName() == 'api_my_admin.cms.scripts.index') {
            return 'scripts';
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
