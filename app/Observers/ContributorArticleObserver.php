<?php

namespace App\Observers;

use App\Models\ContributorArticle;

class ContributorArticleObserver
{
  /**
   * Handle the ContributorArticle "created" event.
   */
  public function created(ContributorArticle $contributorArticle): void
  {
    //
  }

  /**
   * Handle the ContributorArticle "updated" event.
   */
  public function updated(ContributorArticle $contributorArticle): void
  {
    if ($contributorArticle->isDirty('thumbnail')) {
      Storage::disk('public')->delete($contributorArticle->getOriginal('thumbnail'));
    }

    if($contributorArticle->isDirty('images')) {
      Storage::disk('public')->delete($contributorArticle->getOriginal('images'));
    }
  }

  /**
   * Handle the ContributorArticle "deleted" event.
   */
  public function deleted(ContributorArticle $contributorArticle): void
  {
    //
  }

  /**
   * Handle the ContributorArticle "restored" event.
   */
  public function restored(ContributorArticle $contributorArticle): void
  {
    //
  }

  /**
   * Handle the ContributorArticle "force deleted" event.
   */
  public function forceDeleted(ContributorArticle $contributorArticle): void
  {
    if (!is_null($contributorArticle->thumbnail)) {
      Storage::disk('public')->delete($contributorArticle->thumbnail);
    }

    if (!is_null($contributorArticle->images)) {
      Storage::disk('public')->delete($contributorArticle->images);
    }
  }
}
