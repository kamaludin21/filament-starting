<?php

namespace App\Filament\Resources;

use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use App\Filament\Resources\MainArticleResource\Pages;
use App\Filament\Resources\MainArticleResource\RelationManagers\PublishedRelationManager;
use App\Filament\Resources\MainArticleResource\RelationManagers\TagsRelationManager;
use App\Models\ArticleCategory;
use App\Models\MainArticle;
use App\Models\Tag;
use Carbon\Carbon;
use DateTime;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TimePicker;
use Filament\Support\RawJs;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Date;

use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Filament\Forms\Components\Fieldset;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MainArticleResource extends Resource
{
  protected static ?string $model = MainArticle::class;
  protected static ?string $navigationGroup = 'Artikel';
  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Group::make([
          Section::make('Form Artikel')
            ->description('Formulir artikel berita utama')
            ->schema([
              TextInput::make('title')
                ->maxLength(256)
                ->required()
                ->label('Judul berita')
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->placeholder('Judul berita/artikel')
                ->autocomplete(false)
                ->columnSpanFull(),
              TextInput::make('slug')
                ->required()
                ->maxLength(270)
                ->columnSpanFull(),
              Select::make('article_category_id')
                ->native('false')
                ->required()
                ->label('Kategori Berita')
                ->options(ArticleCategory::all()
                  ->pluck('name', 'id')->map(function ($name) {
                    return ucwords($name);
                  })),
              Select::make('tags')
                ->label('Tags')
                ->helperText('Max: 5 Tag')
                ->multiple()
                ->maxItems(5)
                ->relationship('tags', 'name')
                ->createOptionForm([
                  TextInput::make('name')
                    ->unique()
                    ->required()
                    ->label('Tag')
                    ->helperText('Max: 30 Karakter')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->placeholder('Tag')->autocomplete(false),
                  TextInput::make('slug')->readOnly()->required(),
                ])
                ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                  return $action
                    ->modalHeading('Create Tag')
                    ->modalWidth('lg');
                }),
              TextInput::make('thumbnail_alt')
                ->required()
                ->maxLength(100)
                ->placeholder('Teks keterangan gambar')
                ->label('Keterangan gambar')
                ->helperText('Max: 100 Karakter')->columnSpanFull(),
              FileUpload::make('thumbnail')
                ->required()
                ->image()
                ->maxSize(1024)
                ->label('Thumbnail')
                ->helperText('Max Size: 1024KB'),
              FileUpload::make('images')
                ->maxFiles(5)
                ->image()
                ->multiple()
                ->reorderable()
                ->label('Kumpulan Gambar Artikel')
                ->helperText('Max: 5 File'),
              RichEditor::make('content')
                ->required()
                ->maxLength(5000)
                ->label('Kontent')->columnSpanFull(),
            ])
            ->columns(2),

          Section::make('Publikasi')
            ->relationship('published')
            ->description('Atur Publikasi Artikel')
            ->schema([
              DatePicker::make('publish_date')
                ->required()
                ->native(false)
                ->minDate(today())
                ->maxDate(Carbon::now()->addDays(3))
                ->default(today())
                ->displayFormat('D d/m/Y')
                ->label('Tanggal Publikasi')
                ->closeOnDateSelection(),

              Radio::make('edited_status')
                ->required()
                ->options([
                  'drafted' => 'Draft',
                  'completed' => 'Selesai',
                  'archived' => 'Arsip',
                ])
                ->label('Status Edit')
                ->default('drafted'),

              Radio::make('publish_status')
                ->required()
                ->options([
                  'queue' => 'Antrian',
                  'preview' => 'Preview',
                  'hold' => 'Tahan',
                  'publish' => 'Publish'
                ])
                ->descriptions([
                  'queue' => 'Artikel dalam antrian',
                  'preview' => 'Artikel sedang di review',
                  'hold' => 'Artikel ditahan sementara',
                  'publish' => 'Artikel di publish'
                ])
                ->label('Status Publikasi')
                ->default('queue'),
            ])
            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Model $record): array {
              $edited_history = [
                'stakeholder_id' => auth()->id(),
                'article_category_id' => $record['id'],
                'title' => $record['title'],
                'slug' => $record['slug'],
                'content' => $record['content'],
                'thumbnail' => $record['thumbnail'],
                'thumbnail_alt' => $record['thumbnail_alt'],
                'images' => $record['images'],
              ];
              $data['edited_history'] = $edited_history;
              $data['stakeholder_id'] = auth()->id();
              return $data;
            })
            ->mutateRelationshipDataBeforeSaveUsing(function (array $data, Model $record): array {
              dd($record['title']);
              $edited_history = [
                'stakeholder_id' => auth()->id(),
                'article_category_id' => $record['id'],
                'title' => $record['title'],
                'slug' => $record['slug'],
                'content' => $record['content'],
                'thumbnail' => $record['thumbnail'],
                'thumbnail_alt' => $record['thumbnail_alt'],
                'images' => $record['images'],
              ];
              $data['edited_history'] = $edited_history;
              $data['stakeholder_id'] = auth()->id();
              return $data;
            })
            ->columns(3),
        ])->columnSpanFull(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('title')->sortable()->label('Judul Artikel')->wrap(),
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
