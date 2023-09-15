<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainArticle extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'stakeholder_id',
    'article_category_id',
    'published_id',
    'slug',
    'title',
    'content',
    'thumbnail',
    'images',
  ];

  protected $guarded = [
    'edited_status'
  ];

  public function stakeholder()
  {
    return $this->hasOne(Stakeholder::class);
  }

  public function articleCategory()
  {
    return $this->hasOne(ArticleCategory::class);
  }

  public function published()
  {
    return $this->hasOne(Published::class);
  }

  public function tags()
  {
    return $this->morphToMany(Tag::class, 'tags', 'article_tags');
  }

	// public function viewCounter()
	// {
	// 	return $this->hasOne(ViewCounter::class);
	// }

}
