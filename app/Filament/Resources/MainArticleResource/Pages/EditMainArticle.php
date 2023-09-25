<?php

namespace App\Filament\Resources\MainArticleResource\Pages;

use App\Filament\Resources\MainArticleResource;
use App\Models\Published;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditMainArticle extends EditRecord
{
  protected static string $resource = MainArticleResource::class;

  protected function handleRecordUpdate(Model $record, array $data): Model
  {
    $edited_history = [
      'stakeholder_id' => auth()->id(),
      'article_category_id' => $data['article_category_id'],
      'title' => $data['title'],
      'slug' => $data['slug'],
      'content' => $data['content'],
      'thumbnail' => $data['thumbnail'],
      'thumbnail_alt' => $data['thumbnail_alt'],
      'images' => $data['images'],
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
    ];
  }
}
