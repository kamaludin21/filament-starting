<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Str;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagResource extends Resource
{
  protected static ?string $model = Tag::class;

  protected static ?string $navigationIcon = 'heroicon-o-tag';
  protected static ?string $navigationGroup = 'Data Master';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Form Tag')
          ->description('Data tag pada artikel berita')
          ->schema([
            TextInput::make('name')
              ->unique()
              ->label('Suku kata')
              ->helperText('Max: 30 Karakter')
              ->live(onBlur: true)
              ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->placeholder('Suku kata')->required()->autocomplete(false),
            TextInput::make('slug')->readOnly()->required(),
            Radio::make('is_muted')
              ->label('Sembunyikan kata tag ini?')
              ->boolean()->default(false)
          ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')
          ->forceSearchCaseInsensitive()
          ->label('Tag')
          ->sortable()
          ->searchable(),
        ToggleColumn::make('is_muted')
          ->label('Disembunyikan')
          ->toggleable()
          ->toggledHiddenByDefault()
          ->label('Is Mute'),
        TextColumn::make('created_at')
          ->label('Dibuat')
          ->date()
          ->toggleable()
      ])
      ->filters([
        TrashedFilter::make()
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
      'index' => Pages\ListTags::route('/'),
      'create' => Pages\CreateTag::route('/create'),
      'edit' => Pages\EditTag::route('/{record}/edit'),
    ];
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class);
  }
}
