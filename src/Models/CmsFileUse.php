<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsFileUse extends Model
{
    use HasFactory;

    protected $table = "my_cms_files_uses";

    public function file()
    {
        return $this->belongsTo(CmsTheme::class, 'id', 'file_id');
    }
}
