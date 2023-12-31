<?php

namespace App\Filament\Resources\MainArticleResource\Pages;

use App\Filament\Resources\MainArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMainArticle extends ViewRecord
{
  protected static string $resource = MainArticleResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\EditAction::make(),
      Actions\ForceDeleteAction::make(),
      Actions\RestoreAction::make(),
    ];
  }
}
