<?php

namespace App\Filament\Resources\ContributorArticleResource\Pages;

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
}
