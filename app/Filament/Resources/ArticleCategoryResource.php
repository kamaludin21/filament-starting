<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleCategoryResource\Pages;
use App\Models\ArticleCategory;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleCategoryResource extends Resource
{
  protected static ?string $model = ArticleCategory::class;

  protected static ?string $navigationIcon = 'heroicon-o-swatch';
  protected static ?string $navigationGroup = 'Data Master';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Formulir Kategori')
          ->description('Data kategori untuk artikel')
          ->schema([
            TextInput::make('name')
              ->unique(ignoreRecord: true)
              ->label('Nama Kategori')
              ->live(onBlur: true)
              ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->placeholder('Nama Kategori')->required()->autocomplete(false),
            TextInput::make('slug')->readOnly()->required(),
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
          ->label('Kategori')
          ->sortable()
          ->searchable(),
        TextColumn::make('description')
          ->label('Keterangan')
          ->wrap()
          ->toggleable()
          ->toggledHiddenByDefault(),
        TextColumn::make('created_at')
          ->label('Dibuat')
          ->dateTime()
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
      'index' => Pages\ListArticleCategories::route('/'),
      'create' => Pages\CreateArticleCategory::route('/create'),
      'edit' => Pages\EditArticleCategory::route('/{record}/edit'),
    ];
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class);
  }
}
