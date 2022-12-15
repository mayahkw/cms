<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPathLangBlock extends Model
{
    use HasFactory;

    protected $table = "my_cms_paths_langs_blocks";

    public function block()
    {
        return $this->belongsTo(CmsBlock::class, 'block_id');
    }
}
