<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsBlock extends Model
{
    use HasFactory;

    protected $table = "my_cms_blocks";

    public function scripts()
    {
        return $this->hasMany(CmsBlockScript::class, 'block_id', 'id');
    }

    /*public function theme()
    {
        return $this->belongsTo(CmsTheme::class, 'theme_id');
    }*/
}
