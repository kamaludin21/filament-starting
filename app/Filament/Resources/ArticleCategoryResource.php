<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleCategoryResource\Pages;
use App\Models\ArticleCategory;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleCategoryResource extends Resource
{
  protected static ?string $model = ArticleCategory::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?string $navigationGroup = 'Data Master';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Formulir Kategori')
          ->description('Data kategori untuk artikel')
          ->schema([
            TextInput::make('name')
              ->unique()
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
      'index' => Pages\ListArticleCategories::route('/'),
      'create' => Pages\CreateArticleCategory::route('/create'),
      'edit' => Pages\EditArticleCategory::route('/{record}/edit'),
    ];
  }
}
