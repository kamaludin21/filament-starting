<?php

namespace App\Observers;

use App\Models\MainArticle;
use Illuminate\Support\Facades\Storage;

class MainArticleObserver
{
  /**
   * Handle the MainArticle "created" event.
   */
  public function created(MainArticle $mainArticle): void
  {
    //
  }

  /**
   * Handle the MainArticle "updated" event.
   */
  public function updated(MainArticle $mainArticle): void
  {
    // if ($mainArticle->isDirty('thumbnail')) {
    //   Storage::disk('public')->delete($mainArticle->getOriginal('thumbnail'));
    // }

    // if($mainArticle->isDirty('images')) {
    //   Storage::disk('public')->delete($mainArticle->getOriginal('images'));
    // }
  }

  /**
   * Handle the MainArticle "deleted" event.
   */
  public function deleted(MainArticle $mainArticle): void
  {
    //
  }

  /**
   * Handle the MainArticle "restored" event.
   */
  public function restored(MainArticle $mainArticle): void
  {
    //
  }

  /**
   * Handle the MainArticle "force deleted" event.
   */
  public function forceDeleted(MainArticle $mainArticle): void
  {
    if (!is_null($mainArticle->thumbnail)) {
      Storage::disk('public')->delete($mainArticle->thumbnail);
    }

    if(!is_null($mainArticle->images)) {
      Storage::disk('public')->delete($mainArticle->images);
    }
  }
}
