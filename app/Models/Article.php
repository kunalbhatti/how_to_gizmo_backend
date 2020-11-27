<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'status', 'image', 'description', 'content', 'backend', 'frontend', 'database', 'libraries'];

    public function archives() {
        return $this->hasMany('App\Models\Archive');
    }
}
