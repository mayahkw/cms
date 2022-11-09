<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPath extends Model
{
    use HasFactory;

    protected $table = "cms_paths";

    public function langs()
    {
        return $this->hasMany(CmsPathLang::class, 'path_id', 'id')->orderby('lang', 'ASC');
    }

    public function theme()
    {
        return $this->belongsTo(CmsTheme::class, 'theme_id');
    }
}
