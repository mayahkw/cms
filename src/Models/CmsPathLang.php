<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPathLang extends Model
{
    use HasFactory;

    protected $table = "my_cms_paths_langs";

    public function lang()
    {
        return $this->belongsTo(CmsPathLang::class, 'path_lang_id');
    }

    public function theme()
    {
        return $this->belongsTo(CmsTheme::class, 'id', 'lang_id');
    }

    public function blocks()
    {
        return $this->hasMany(CmsPathLangBlock::class, 'path_lang_id', 'id');
    }
}
