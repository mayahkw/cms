<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPathLang extends Model
{
    use HasFactory;

    protected $table = "my_cms_paths_langs";

    public function page()
    {
        return $this->belongsTo(CmsPath::class, 'path_id');
    }

    public function theme()
    {
        return $this->belongsTo(CmsTheme::class, 'theme_id');
    }

    public function blocks()
    {
        return $this->hasMany(CmsPathLangBlock::class, 'path_lang_id', 'id');
    }
}
