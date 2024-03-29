<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagArticle extends Model
{
    use HasFactory;
    protected $fillable = array('articleId', 'tagId');
    public $timestamps = false;
}
