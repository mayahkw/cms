<?php

namespace Mayahkw\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mayahkw\Admin\Facades\MyAdmin;
use Mayahkw\CMS\Facades\MyCms;
use Mayahkw\CMS\Models\CmsThemeBlock;

class ThemeBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {

        if (Route::currentRouteName() == 'api_my_admin.cms.themes.blocks.index') {
            return '';
        }

        return MyAdmin::page();
    }

    /**
     * Display the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsThemeBlock
     * @return \Illuminate\Http\Response
     */
    public function show(CmsThemeBlock $block)
    {
        $block->options = json_decode($block->options);
        $block->value = json_decode($block->value);

        if (Route::currentRouteName() == 'api_my_admin.cms.themes.blocks.show') {
            return $block;
        }

        return MyAdmin::page();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsThemeBlock
     * @return \Illuminate\Http\Response
     */
    public function edit($data)
    {
        //dd($data);
        if ($data['id'] == -1) {
            $block = new CmsThemeBlock();
            $block->user_id = Auth::user()->id;
        } else {
            $block = CmsThemeBlock::find($data['id']);
        }

        !isset($data['theme_id']) ?: $block->theme_id = $data['theme_id'];
        !isset($data['block_id']) ?: $block->block_id = $data['block_id'];
        !isset($data['options']) ?: $block->options = json_encode($data['options']);
        !isset($data['operators']) ?: $block->operators = json_encode($data['operators']);
        !isset($data['value']) ?: $block->value = json_encode($data['value']);
        $block->lang = (isset($data['lang']) ? $block->lang = $data['lang'] : 1);

        $block->order = (!isset($data['order']) ? 1 :  $data['order']);
        is_null($data['parent_id']) ?: $block->parent_id = $data['parent_id'];
        $block->save();

        return $block;
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
     * @param  Mayahkw\CMS\Models\CmsThemeBlock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CmsThemeBlock $block)
    {
        return $this->edit(request()->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Mayahkw\CMS\Models\CmsThemeBlock
     * @return \Illuminate\Http\Response
     */
    public function destroy(CmsThemeBlock $block)
    {
        //
    }
}
