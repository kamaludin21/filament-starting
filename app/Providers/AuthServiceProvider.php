<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\ContributorArticle;
use App\Models\MainArticle;
use App\Policies\ContributorArticlePolicy;
use App\Policies\MainArticlePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The model to policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    MainArticle::class => MainArticlePolicy::class,
    ContributorArticle::class => ContributorArticlePolicy::class,
  ];

  /**
   * Register any authentication / authorization services.
   */
  public function boot(): void
  {
    //
  }
}
