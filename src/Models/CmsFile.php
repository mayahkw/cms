<?php

namespace Mayahkw\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsFile extends Model
{
    use HasFactory;

    protected $table = "my_cms_files";

    public function uses()
    {
        return $this->hasMany(CmsFilesUses::class, 'file_id', 'id');
    }
}
