<?php

namespace App\Filament\Resources\MainArticleResource\Pages;

use App\Filament\Resources\MainArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMainArticle extends EditRecord
{
    protected static string $resource = MainArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
