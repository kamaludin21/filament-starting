<?php

namespace App\Models;

use App\Enums\EditedStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContributorArticle extends Model
{
  use HasFactory, SoftDeletes;

  protected $guarded = [
    'main_article_id',
    'edited_status'
  ];

  protected $casts = [
    'images' => 'array',
    'edited_status' => EditedStatus::class,
  ];

  public function articleCategory(): BelongsTo
  {
    return $this->belongsTo(ArticleCategory::class, 'article_category_id');
  }

  public function tags(): BelongsToMany
  {
    return $this->belongsToMany(Tag::class, 'article_tags', 'tag_id', 'article_id')->withTimestamps();
  }
}
