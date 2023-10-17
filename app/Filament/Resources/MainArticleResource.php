<?php

namespace App\Filament\Resources;

use App\Enums\EditedStatus;
use App\Enums\PublishStatus;
use App\Filament\Resources\MainArticleResource\Pages;
use App\Models\MainArticle;
use App\Models\ArticleCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\Tabs as ComponentsTabs;
use Filament\Infolists\Components\Tabs\Tab as TabsTab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\ViewEntry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MainArticleResource extends Resource
{
  protected static ?string $model = MainArticle::class;
  protected static ?string $navigationGroup = 'Artikel';
  protected static ?string $navigationIcon = 'heroicon-o-newspaper';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Group::make([
          Section::make('Form Artikel')
            ->description('Formulir artikel berita utama')
            ->schema([
              Textarea::make('title')
                ->autosize()
                ->label('Judul berita')
                ->placeholder('Judul berita/artikel')
                ->maxLength(256)
                ->autocomplete(false)
                ->required()
                ->live(onBlur: true)
                ->dehydrated()
                ->afterStateUpdated(function (Set $set, ?string $state) {
                  $set('slug', Str::slug($state));
                })
                ->columnSpanFull(),

              TextInput::make('slug')
                ->label('Slug')
                ->placeholder('Slug')
                ->maxLength(270)
                ->disabled()
                ->dehydrated()
                ->readOnly(),

              Select::make('article_category_id')
                ->label('Kategori Berita')
                ->native('false')
                ->required()
                ->options(ArticleCategory::all()->pluck('name', 'id')->map(function ($name) {
                  return ucwords($name);
                })),

              Select::make('tags')
                ->searchable()
                ->label('Tags')
                ->helperText('Max: 5 Tag')
                ->multiple()
                ->maxItems(5)
                ->relationship('tags', 'name')
                ->createOptionForm([
                  TextInput::make('name')
                    ->label('Tag')
                    ->placeholder('Tag')
                    ->maxLength(30)
                    ->helperText('Max: 30 Karakter')
                    ->live(onBlur: true)
                    ->unique()
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                  TextInput::make('slug')
                    ->readOnly(),
                ])
                ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                  return $action
                    ->modalHeading('Create Tag')
                    ->modalWidth('lg');
                })
                ->columnSpanFull(),

              TextInput::make('thumbnail_alt')
                ->label('Keterangan gambar')
                ->placeholder('Teks keterangan gambar')
                ->maxLength(100)
                ->helperText('Max: 100 Karakter')
                ->required()
                ->columnSpanFull(),

              FileUpload::make('thumbnail')
                ->label('Gambar')
                ->image()
                ->directory(date('Y') . '/' . date('m'))
                ->required()
                ->maxSize(1024)
                ->helperText('Max Size: 1024KB'),

              FileUpload::make('images')
                ->label('Kumpulan Gambar')
                ->image()
                ->directory(date('Y') . '/' . date('m'))
                ->maxFiles(5)
                ->multiple()
                ->reorderable()
                ->helperText('Max: 5 File'),

              RichEditor::make('content')
                ->label('Kontent')
                ->maxLength(5000)
                ->required()
                ->columnSpanFull()
            ])->columns(2),

        ])->columnSpan(['lg' => 2]),
        Group::make([
          Section::make('Publikasi')
            ->relationship('published')
            ->description('Atur Publikasi Artikel')
            ->schema([
              Radio::make('edited_status')
                ->label('Status Edit')
                ->required()
                ->reactive()
                ->default('drafted')
                ->options(EditedStatus::class),

              Radio::make('publish_status')
                ->label('Status Publikasi')
                ->hidden(function ($get) {
                  if ($get('edited_status') !== 'completed') {
                    return true;
                  }
                  return false;
                })
                ->required()
                ->reactive()
                ->default('queue')
                ->options(PublishStatus::class)
                ->descriptions([
                  'queue' => 'Artikel dalam antrian',
                  'preview' => 'Artikel sedang di review',
                  'hold' => 'Artikel ditahan sementara',
                  'publish' => 'Artikel di publish'
                ]),

              DatePicker::make('publish_date')
                ->label('Tanggal Publikasi')
                ->visible(function ($get) {
                  if ($get('publish_status') === 'publish') {
                    return true;
                  }
                  return false;
                })
                ->required()
                ->minDate(function ($get) {
                  return $get('publish_date') ?: today();
                })
                ->maxDate(function ($get) {
                  $date = $get('publish_date') ? Carbon::parse($get('publish_date')) : Carbon::now();
                  return $date->addDays(5);
                })
                ->reactive()
                ->seconds(false)
                ->native(false)
                ->displayFormat('D d/m/Y')
                ->closeOnDateSelection(),
            ])
            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Model $record): array {
              $tags = $record->tags->pluck('name')->filter();
              $edited_history = [
                'stakeholder_id' => auth()->id(),
                'article_category' => $record->articleCategory->name,
                'title' => $record->title,
                'slug' => $record->slug,
                'content' => $record->content,
                'thumbnail' => $record->thumbnail,
                'thumbnail_alt' => $record->thumbnail_alt,
                'images' => $record->images,
                'tags' => $tags,
                'modify_at' => $record->created_at->toDateTimeString(),
              ];
              $data['edited_history'] = [$edited_history];
              $data['stakeholder_id'] = auth()->id();
              return $data;
            }),
        ])->columnSpan(['lg' => 1]),
      ])->columns(3);
  }

  public static function infolist(Infolist $infolist): Infolist
  {
    return $infolist
      ->schema([
        ComponentsTabs::make('tabs')->schema([
          TabsTab::make('Informasi Artikel')->schema([
            TextEntry::make('articleCategory.name')->label('Kategori'),
            TextEntry::make('tags.name')->badge(),
            TextEntry::make('title')->label('Judul Artikel'),
            TextEntry::make('slug')->label('Slug Artikel'),
            ImageEntry::make('thumbnail')->label('Gambar'),
            TextEntry::make('thumbnail_alt')->label('Keterangan Gambar'),
            ImageEntry::make('images')->label('Kumpulan Gambar')->columnSpanFull(),
            TextEntry::make('content')->html()->label('Konten')->columnSpanFull(),
          ])->columns(2),
          TabsTab::make('published')->label('Publikasi')->schema([
            TextEntry::make('published.edited_status')->label('Status Pengeditan')->badge(),
            TextEntry::make('published.publish_status')->label('Status Publikasi')->badge(),
            TextEntry::make('created_at')->label('Tanggal Buat')->dateTime(),
            TextEntry::make('published.publish_date')->label('Tanggal Publikasi')->dateTime(),
            ViewEntry::make('published.edited_history')->view('livewire.collapsible-card')->columnSpanFull(),
          ])->columns(2),

          TabsTab::make('Author')->schema([
            TextEntry::make('users.name')->label('Nama'),
            TextEntry::make('institutes.name')->label('Instansi/OPD'),
            TextEntry::make('stakeholders.level')->label('Level'),
            TextEntry::make('stakeholders.position')->label('Posisi'),
            TextEntry::make('stakeholders.photo')->label('Photo'),
            TextEntry::make('stakeholders.description')->label('Bio'),
          ])->columns(2),
        ])->columnSpanFull()
      ])->columns(2);
  }


  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('title')
          ->searchable()
          ->forceSearchCaseInsensitive()
          ->label('Judul Artikel')
          ->sortable()
          ->wrap(),

        TextColumn::make('articleCategory.name')
          ->label('Kategori')
          ->sortable()
          ->wrap()
          ->toggleable(),
        TextColumn::make('published.publish_status')
          ->label('Status')
          ->placeholder('Kosong')
          ->sortable()
          ->wrap()
          ->badge()
          ->toggleable()
          ->toggledHiddenByDefault(),

        TextColumn::make('published.publish_date')
          ->label('Tanggal Publikasi')
          ->placeholder('Kosong')
          ->date()
          ->sortable()
          ->wrap()
          ->toggleable()
          ->toggledHiddenByDefault(),

        TextColumn::make('created_at')
          ->label('Dibuat pada')
          ->placeholder('Kosong')
          ->date()
          ->sortable()
          ->wrap()
          ->toggleable()
          ->toggledHiddenByDefault(),
      ])
      ->defaultSort('created_at', 'desc')
      ->filters([
        Tables\Filters\SelectFilter::make('articleCategory')
          ->label('Kategori')
          ->relationship('articleCategory', 'name')
          ->multiple()
          ->preload(),

        Tables\Filters\TrashedFilter::make(),
      ])
      ->actions([
        Tables\Actions\ActionGroup::make([
          Tables\Actions\ViewAction::make(),
          Tables\Actions\EditAction::make(),
          Tables\Actions\DeleteAction::make(),
        ]),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
          Tables\Actions\ForceDeleteBulkAction::make(),
          Tables\Actions\RestoreBulkAction::make()
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
      'index' => Pages\ListMainArticles::route('/'),
      'create' => Pages\CreateMainArticle::route('/create'),
      'edit' => Pages\EditMainArticle::route('/{record}/edit'),
      'view' => Pages\ViewMainArticle::route('/{record}')
    ];
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class);
  }
}
