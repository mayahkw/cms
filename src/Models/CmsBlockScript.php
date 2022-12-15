<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsBlockScript extends Model
{
    use HasFactory;

    protected $table = "my_cms_blocks_scripts";

    /*
    public function page()
    {
        return $this->belongsTo(CmsPath::class, 'path_id');
    }*/
}
