<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEO extends Model {
    use HasFactory;

    protected $table = 'seos';

    protected $fillable = ['uri', 'title', 'description'];

    public function keywords() {
        return $this->hasMany(Keyword::class, 'seo_id');
    }
}
