<?php

namespace App\Filament\Resources\ContributorArticleResource\Pages;

use App\Filament\Resources\ContributorArticleResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditContributorArticle extends EditRecord
{
  protected static string $resource = ContributorArticleResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
      Actions\ForceDeleteAction::make(),
      Actions\RestoreAction::make(),
    ];
  }
}
