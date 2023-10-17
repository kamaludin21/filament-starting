<?php

namespace App\Filament\Resources\ContributorArticleResource\Pages;

use App\Filament\Resources\ContributorArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContributorArticle extends ViewRecord
{
  protected static string $resource = ContributorArticleResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\EditAction::make(),
      Actions\ForceDeleteAction::make(),
      Actions\RestoreAction::make(),
    ];
  }
}
