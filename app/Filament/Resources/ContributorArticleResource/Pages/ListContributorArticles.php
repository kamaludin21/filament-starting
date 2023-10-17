<?php

namespace App\Filament\Resources\ContributorArticleResource\Pages;

use App\Enums\EditedContributor;
use App\Filament\Resources\ContributorArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContributorArticles extends ListRecords
{
  protected static string $resource = ContributorArticleResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }

  public function getTabs(): array
  {
    return [
      'all' => ListRecords\Tab::make('All')->label('Semua'),
      'completed' => ListRecords\Tab::make('completed')
      ->label('Selesai')
      ->query(fn ($query) => $query->where('edited_status', EditedContributor::COMPLETED)),

      'published' => ListRecords\Tab::make('published')
      ->label('Publikasi')
      ->query(fn ($query) => $query->where('edited_status', EditedContributor::PUBLISHED)),

      'archived' => ListRecords\Tab::make('archived')
      ->label('Arsip')
      ->query(fn ($query) => $query->where('edited_status', EditedContributor::ARCHIVED)),

      'drafted' => ListRecords\Tab::make('drafted')
        ->label('Draf')
        ->query(fn ($query) => $query->where('edited_status', EditedContributor::DRAFTED)),

      ];
    }
  }
