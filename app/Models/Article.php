<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Article extends Model
{
    use HasFactory;
    protected $guard = array('createdAt', 'updatedAt');
    protected $fillable = array('slug', 'title', 'description', 'body', 'author');
    public $timestamps = false;

    public static $rules = array(
        'slug' => 'required',
        'title' => 'required',
        'description' => 'required',
        'body' => 'required',
    );

    // protected function serializeDate(DateTimeInterface $date)
    // {
    //     return $date->format('YYYY');
    // }

}
