<?php

namespace App\Providers;

use App\Models\ContributorArticle;
use App\Models\MainArticle;
use App\Observers\ContributorArticleObserver;
use App\Observers\MainArticleObserver;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    MainArticle::observe(MainArticleObserver::class);
    ContributorArticle::observe(ContributorArticleObserver::class);
    FilamentAsset::register([
      Css::make('custom-stylesheet', __DIR__ . '/../../resources/css/custom.css'),
    ]);
  }
}
