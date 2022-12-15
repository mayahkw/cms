<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsThemeBlock extends Model
{
    use HasFactory;

    protected $table = "my_cms_themes_blocks";

    public function block()
    {
        return $this->belongsTo(CmsBlock::class,  'block_id', 'id');
    }
}
