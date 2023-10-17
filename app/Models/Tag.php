<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'name', 'slug', 'is_muted'
  ];

  public function mainArticle(): BelongsToMany
  {
    return $this->belongsToMany(MainArticle::class, 'article_tags', 'tag_id', 'article_id');
  }

  public function contributorArticle(): BelongsToMany
  {
    return $this->belongsToMany(MainArticle::class, 'article_tags', 'tag_id', 'article_id');
  }
}
