<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = ['id', 'article_id', 'question', 'answer', 'html', 'css', 'frontend', 'backend', 'database', 'type'];
}
