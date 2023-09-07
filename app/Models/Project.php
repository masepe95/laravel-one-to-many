<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['title', 'slug', 'image', 'description', 'main_lang', 'other_langs', 'n_stars', 'is_public'];
}
