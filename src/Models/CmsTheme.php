<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsTheme extends Model
{
    use HasFactory;

    protected $table = "my_cms_themes";

    public function langs()
    {
        return $this->hasMany(CmsPathLang::class, 'theme_id');
    }

    public function blocks()
    {
        return $this->hasMany(CmsThemeBlock::class, 'theme_id')->where('active', 1)->where('parent_id', null);
    }

    public function scripts()
    {
        return $this->hasMany(CmsThemeScript::class, 'theme_id')->where('active', 1);
    }
}
