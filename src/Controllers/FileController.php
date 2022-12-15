<?php

namespace Mayahkw\CMS\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Mayahkw\Admin\Facades\MyAdmin;
use Mayahkw\CMS\Models\CmsFile;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $files = CmsFile::where('active', 1);
        $files->paginate(15);


        if (Route::currentRouteName() == 'api_my_admin.cms.blocks.index') {
            return $files;
        }

        return MyAdmin::page();
    }

    /**
     * Display the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsFile
     * @return \Illuminate\Http\Response
     */
    public function show(CmsFile $file)
    {
        return $file;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Mayahkw\CMS\Models\CmsFile
     * @return \Illuminate\Http\Response
     */
    public function edit($data)
    {
        // Storage::disk('public')->put('cms', $data['file_0']);
        //$url = Storage::disk('public')->url('cms/003.jpg');


        if (isset($data['id'])) {
            if ($data['id'] == -1) {
                $dir = (isset($data['dir']) ? $data['dir'] : 'files/all');
                $description = isset($data['description']) ? $data['description'] : '';
                $name = Carbon::now()->timestamp . '.' . $data['file']->getClientOriginalExtension();
                $original =  $data['file']->getClientOriginalName();
                $type =  $data['file']->getMimeType();

                $data['file']->move($dir, $name);

                $file = new  CmsFile();
                $file->user_id = Auth::user()->id;
                $file->type = $type;
                $file->description = $description;
                $file->original = $original;
                $file->dir = $dir;
                $file->name = $name;
                $file->save();
            } else {
                $file = CmsFile::find($data['id']);
            }


            return ($file);
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
     * @param  Mayahkw\CMS\Models\CmsFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CmsFile $file)
    {
        return $this->edit(request()->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Mayahkw\CMS\Models\CmsFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(CmsFile $file)
    {
        //
    }
}
