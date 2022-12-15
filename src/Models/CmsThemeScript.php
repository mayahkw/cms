<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsThemeScript extends Model
{
    use HasFactory;

    protected $table = "my_cms_themes_scripts";

    public function script()
    {
        return $this->belongsTo(CmsPath::class, 'script_id');
    }
}
