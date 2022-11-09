<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPathLang extends Model
{
    use HasFactory;

    protected $table = "cms_paths_langs";

    public function page()
    {
        return $this->belongsTo(CmsPath::class, 'path_id');
    }
}
