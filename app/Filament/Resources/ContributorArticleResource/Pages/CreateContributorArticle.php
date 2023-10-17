<?php

namespace App\Filament\Resources\ContributorArticleResource\Pages;

use App\Filament\Resources\ContributorArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContributorArticle extends CreateRecord
{
  protected static string $resource = ContributorArticleResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['stakeholder_id'] = auth()->id();
    return $data;
  }
}
