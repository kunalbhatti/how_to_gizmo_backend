<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'status', 'image', 'description', 'content', 'backend', 'frontend', 'database', 'libraries', 'git'];

    public function projects() {
        return $this->belongsToMany('App\Models\Project');
    }

    public function archives() {
        return $this->belongsToMany('App\Models\Archive');
    }
}
