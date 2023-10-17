<?php

namespace App\Policies;

use App\Models\ContributorArticle;
use App\Models\User;

class ContributorArticlePolicy
{
  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, ContributorArticle $contributorArticle): bool
  {
    return !empty($contributorArticle->deleted_at) ? false : true;
  }
}
