<?php

namespace App\Filament\Resources\MainArticleResource\Pages;

use App\Filament\Resources\MainArticleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMainArticle extends CreateRecord
{
  protected static string $resource = MainArticleResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['stakeholder_id'] = 1;
    return $data;
  }
}
