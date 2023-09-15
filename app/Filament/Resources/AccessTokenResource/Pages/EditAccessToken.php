<?php

namespace App\Filament\Resources\AccessTokenResource\Pages;

use App\Filament\Resources\AccessTokenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccessToken extends EditRecord
{
    protected static string $resource = AccessTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
