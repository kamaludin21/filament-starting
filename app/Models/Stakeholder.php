<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stakeholder extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'institute_id',
    'user_id',
    'is_active',
    'level',
    'position',
    'photo',
    'description'
  ];

  public function mainArticle(): BelongsTo
  {
    return $this->belongsTo(MainArticle::class);
  }

  public function contributorArticle(): BelongsTo
  {
    return $this->belongsTo(ContributorArticle::class);
  }

  public function instansi(): BelongsTo
  {
    return $this->belongsTo(Institute::class);
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

}
