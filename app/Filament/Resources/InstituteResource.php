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
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstituteResource extends Resource
{
  protected static ?string $model = Institute::class;

  protected static ?string $navigationIcon = 'heroicon-o-building-office';
  protected static ?string $navigationGroup = 'Data Master';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Formulir Instansi')
          ->description('User dari instansi merupakan kontributor data artikel')
          ->schema([
            TextInput::make('name')
              ->unique()
              ->label('Nama Instansi')
              ->live(onBlur: true)
              ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->placeholder('Nama instansi')->required()->autocomplete(false),
            TextInput::make('slug')->required(),
            Textarea::make('description')->label('Keterangan')
          ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')
          ->forceSearchCaseInsensitive()
          ->label('Institusi')
          ->sortable()
          ->searchable(),
        TextColumn::make('description')
          ->label('Keterangan')
          ->searchable()
          ->wrap()
          ->toggleable()
          ->toggledHiddenByDefault(),
        TextColumn::make('created_at')
          ->label('Dibuat')
          ->date()
          ->toggleable()
      ])
      ->filters([
        TrashedFilter::make(),
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make()
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ])
      ->groups([
        Tables\Grouping\Group::make('created_at')
          ->label('Order Date')
          ->collapsible(),
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

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class);
  }
}
