<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    ];

    public function mainArticle(): BelongsTo
    {
      return $this->belongsTo(MainArticle::class);
    }
}
