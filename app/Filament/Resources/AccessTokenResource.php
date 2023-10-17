<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccessTokenResource\Pages;
use App\Filament\Resources\AccessTokenResource\RelationManagers;
use App\Models\AccessToken;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccessTokenResource extends Resource
{
  protected static ?string $model = AccessToken::class;
  protected static ?string $navigationGroup = 'Pengaturan';
  protected static ?string $navigationIcon = 'heroicon-o-shield-check';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        //
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        //
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ])
      ->emptyStateActions([
        Tables\Actions\CreateAction::make(),
      ]);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListAccessTokens::route('/'),
      'create' => Pages\CreateAccessToken::route('/create'),
      'edit' => Pages\EditAccessToken::route('/{record}/edit'),
    ];
  }
}
