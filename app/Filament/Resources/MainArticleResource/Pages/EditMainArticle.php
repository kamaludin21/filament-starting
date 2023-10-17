<?php

namespace App\Filament\Resources\MainArticleResource\Pages;

use App\Filament\Resources\MainArticleResource;
use App\Models\Published;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditMainArticle extends EditRecord
{
  protected static string $resource = MainArticleResource::class;

  protected function handleRecordUpdate(Model $record, array $data): Model
  {
    $data['tags'] = $record->tags->pluck('name')->filter();
    $data['article_category'] = $record->articleCategory->name;

    $edited_history = [
      'stakeholder_id' => auth()->id(),
      'article_category' => $data['article_category'],
      'title' => $data['title'],
      'slug' => $data['slug'],
      'content' => $data['content'],
      'thumbnail' => $data['thumbnail'],
      'thumbnail_alt' => $data['thumbnail_alt'],
      'images' => $data['images'],
      'tags' => $data['tags'],
      'modify_at' => Carbon::now()->toDateTimeString(),
    ];

    $getArticle = Published::where('main_article_id', $record->id)->first();
    $existed_data = $getArticle->edited_history;
    $existed_data[] = $edited_history;
    $getArticle->edited_history = $existed_data;

    $getArticle->save();
    $record->update($data);

    return $record;
  }

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
      Actions\ForceDeleteAction::make(),
      Actions\RestoreAction::make(),
    ];
  }
}
