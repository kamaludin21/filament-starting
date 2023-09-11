<?php

namespace App\Filament\Resources;

use Illuminate\Support\Str;
use App\Models\Institute;
use App\Filament\Resources\InstituteResource\Pages;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables;

class InstituteResource extends Resource
{
  protected static ?string $model = Institute::class;

  protected static ?string $navigationIcon = 'heroicon-o-building-office';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Formulir Instansi/Lembaga')
          ->description('User dari instansi/lembaga merupakan kontributor data artikel')
          ->schema([
            TextInput::make('name')
              ->label('Nama Instansi/Lembaga')
              ->live(onBlur: true)
              ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->placeholder('Nama instansi/lembaga')->required()->autocomplete(false),
            TextInput::make('slug')->required(),
            Textarea::make('description')->label('Keterangan')
          ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')->sortable(),
        TextColumn::make('description')->wrap(),
        TextColumn::make('created_at')->date()
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
      'index' => Pages\ListInstitutes::route('/'),
      'create' => Pages\CreateInstitute::route('/create'),
      'edit' => Pages\EditInstitute::route('/{record}/edit'),
    ];
  }
}
