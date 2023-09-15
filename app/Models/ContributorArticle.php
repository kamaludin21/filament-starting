<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContributorArticle extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
      'main_article_id',
      'edited_status'
    ];
}
