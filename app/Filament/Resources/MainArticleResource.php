<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MainArticleResource\Pages;
use App\Models\ArticleCategory;
use App\Models\MainArticle;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Str;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MainArticleResource extends Resource
{
  protected static ?string $model = MainArticle::class;
  protected static ?string $navigationGroup = 'Artikel';
  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Form Artikel')
          ->description('Formulir artikel berita utama')
          ->schema([
            TextInput::make('title')
              ->unique()
              ->label('Judul berita')
              ->helperText('Max: 30 Karakter')
              ->live(onBlur: true)
              ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->placeholder('Nama instansi/lembaga')->required()->autocomplete(false),
            TextInput::make('slug')->required(),
            Select::make('article_category_id')
              ->label('Kategori Berita')
              ->required()
              ->options(ArticleCategory::all()
                ->pluck('name', 'id')),
            Select::make('tag_id')
              ->label('Tags')
              ->options(Tag::all()->pluck('name', 'id'))
              ->multiple()
              ->maxItems(5)
              ->createOptionForm([
                TextInput::make('name')
                  ->unique()
                  ->label('Suku kata')
                  ->helperText('Max: 30 Karakter')
                  ->live(onBlur: true)
                  ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->placeholder('Suku kata')->required()->autocomplete(false),
                TextInput::make('slug')->required(),
                Radio::make('is_muted')
                  ->label('Sembunyikan kata tag ini?')
                  ->boolean()->default(false)
              ])
              ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                return $action
                  ->modalHeading('Create Tag')
                  ->modalWidth('lg');
              }),
            TextInput::make('thumbnail')->required()->label('Gambar Thumbnail'),
            TextInput::make('images')->label('Gambar'),
            TextInput::make('content')->required()->label('Konten'),
          ])
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
      'index' => Pages\ListMainArticles::route('/'),
      'create' => Pages\CreateMainArticle::route('/create'),
      'edit' => Pages\EditMainArticle::route('/{record}/edit'),
    ];
  }
}
