<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainArticle extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'stakeholder_id',
    'article_category_id',
    'title',
    'slug',
    'content',
    'thumbnail',
    'thumbnail_alt',
    'images'
  ];

  protected $casts = [
    'images' => 'array'
  ];

  public function stakeholder(): HasOne
  {
    return $this->hasOne(Stakeholder::class);
  }

  public function articleCategory(): BelongsTo
  {
    return $this->belongsTo(ArticleCategory::class);
  }

  public function published(): HasOne
  {
    return $this->hasOne(Published::class);
  }

  public function tags(): BelongsToMany
  {
    return $this->belongsToMany(Tag::class, 'article_tags', 'tag_id', 'article_id')->withTimestamps();
  }

  // public function tags(): BelongsTo
  // {
  //   return $this->belongsTo(Tag::class);
  // }

  // public function viewCounter()
  // {
  // 	return $this->hasOne(ViewCounter::class);
  // }

}
