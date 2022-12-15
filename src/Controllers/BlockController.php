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
use Mayahkw\CMS\Models\CmsBlock;
use Mayahkw\CMS\Models\CmsBlockLang;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $blocks = CmsBlock::where('use', 'all');
        !isset(request()->search) ?: $blocks->where('name', 'like', '%' . request()->search . '%');
        !isset(request()->search) ?: $blocks->orwhere('type', 'like', '%' . request()->search . '%');
        !isset(request()->use) ?: $blocks->orwhere('user', request()->use);
        // dd($blocks);
        $blocks = $blocks->paginate(15);

        foreach ($blocks as $block) {
            $block->options = json_decode($block->options);
            $block->value = json_decode($block->value);
        }

        if (Route::currentRouteName() == 'api_my_admin.cms.blocks.index') {
            return $blocks;
        }

        return MyAdmin::page();
    }

    /**
     * Display the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsBlock
     * @return \Illuminate\Http\Response
     */
    public function show(CmsBlock $block)
    {
        $block->options = json_decode($block->options);
        $block->value = json_decode($block->value);

        return $block;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsBlock
     * @return \Illuminate\Http\Response
     */
    public function edit($data)
    {
        if (isset($data['id'])) {
            if ($data['id'] == -1) {
                $block = new  CmsBlock();
                $block->user_id = Auth::user()->id;
                $block->order = 1;
            } else {
                $block = CmsBlock::find($data['id']);
            }

            $block->use = $data['use'];
            $block->type = $data['type'];
            $block->name = $data['name'];
            $block->description = $data['description'];
            $block->options = json_encode($data['options']);
            $block->operators = json_encode($data['operators']);
            $block->value = json_encode($data['value']);
            $block->active = $data['active'];
            $block->save();

            return ($block);
        }
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
     * @param  Mayahkw\CMS\Models\CmsBlock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CmsPath $path)
    {
        return $this->edit(request()->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Mayahkw\CMS\Models\CmsBlock
     * @return \Illuminate\Http\Response
     */
    public function destroy(CmsPath $path)
    {
        //
    }
}
