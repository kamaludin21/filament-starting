<?php

namespace App\Filament\Resources\MainArticleResource\Pages;

use App\Enums\EditedStatus;
use App\Enums\PublishStatus;
use App\Filament\Resources\MainArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMainArticles extends ListRecords
{
  protected static string $resource = MainArticleResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }

  public function getTabs(): array
  {
    return [
      'all' => ListRecords\Tab::make('all')
        ->label('Semua')
        ->query(
          fn ($query) => $query
            ->whereHas(
              'published',
              fn ($query) =>
              $query->where('edited_status', EditedStatus::COMPLETED)
            )
        ),
      'queue' => ListRecords\Tab::make('queue')
        ->label('Antrian')
        ->query(
          fn ($query) => $query
            ->whereHas(
              'published',
              fn ($query) =>
              $query
                ->where('publish_status', PublishStatus::QUEUE)
                ->where('edited_status', EditedStatus::COMPLETED)
            )
        ),
      'preview' => ListRecords\Tab::make('preview')
        ->label('Pemeriksaan')
        ->query(
          fn ($query) => $query
            ->whereHas(
              'published',
              fn ($query) => $query
                ->where('publish_status', PublishStatus::PREVIEW)
                ->where('edited_status', EditedStatus::COMPLETED)
            )
        ),
      'hold' => ListRecords\Tab::make('hold')
        ->label('Ditahan')
        ->query(
          fn ($query) => $query
            ->whereHas(
              'published',
              fn ($query) => $query
                ->where('publish_status', PublishStatus::HOLD)
                ->where('edited_status', EditedStatus::COMPLETED)
            )
        ),
      'publish' => ListRecords\Tab::make('publish')
        ->label('Diterbitkan')
        ->query(
          fn ($query) => $query
            ->whereHas(
              'published',
              fn ($query) => $query
                ->where('publish_status', PublishStatus::PUBLISH)
                ->where('edited_status', EditedStatus::COMPLETED)
            )
        ),
      'drafted' => ListRecords\Tab::make('publish')
        ->label('Draf')
        ->query(
          fn ($query) => $query
            ->whereHas(
              'published',
              fn ($query) => $query
                ->where('edited_status', EditedStatus::DRAFTED)
            )
        ),
    ];
  }
}
