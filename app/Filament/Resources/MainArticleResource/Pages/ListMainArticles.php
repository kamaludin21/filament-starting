<?php

namespace App\Filament\Resources\MainArticleResource\Pages;

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
}
