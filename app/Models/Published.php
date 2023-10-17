<?php

namespace App\Models;

use App\Enums\EditedStatus;
use App\Enums\PublishStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Published extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'stakeholder_id',
    'main_article_id',
    'publish_status',
    'publish_date',
    'edited_status',
    'edited_history'
  ];

  protected $casts = [
    'edited_history' => 'array',
    'publish_date' => 'datetime',
    'publish_status' => PublishStatus::class,
    'edited_status' => EditedStatus::class,
  ];

  public function mainArticle(): BelongsTo
  {
    return $this->belongsTo(MainArticle::class);
  }

}
