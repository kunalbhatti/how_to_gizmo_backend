<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'status', 'image', 'description',
    'content', 'backend', 'frontend', 'database', 'libraries', 'git', 'preview'];

    public function snippets() {
        return $this->belongsToMany('App\Models\Snippet');
    }
}
