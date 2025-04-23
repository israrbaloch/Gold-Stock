<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model {
    use HasFactory;

    protected $fillable = ['value', 'seo_id'];

    public function seo() {
        return $this->belongsTo(SEO::class);
    }
}
