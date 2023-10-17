<?php

namespace App\Policies;

use App\Models\MainArticle;
use App\Models\User;

class MainArticlePolicy
{

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, MainArticle $mainArticle): bool
  {
    return !empty($mainArticle->deleted_at) ? false : true;
  }
}
