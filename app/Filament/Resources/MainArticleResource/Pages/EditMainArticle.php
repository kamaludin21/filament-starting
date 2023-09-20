<?php

namespace App\Filament\Resources\MainArticleResource\Pages;

use App\Filament\Resources\MainArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditMainArticle extends EditRecord
{
  protected static string $resource = MainArticleResource::class;

  // protected function handleRecordUpdate(Model $record, array $data): Model
  // {
    // dd($data['title']);
    // dd($record['title']);
    // $edited_history = [
    //   'stakeholder_id' => auth()->id(),
    //   'article_category_id' => $record['id'],
    //   'title' => $data['title'],
    //   'slug' => $data['slug'],
    //   'content' => $data['content'],
    //   'thumbnail' => $data['thumbnail'],
    //   'thumbnail_alt' => $data['thumbnail_alt'],
    //   'images' => $data['images'],
    // ];
    // $data['edited_history'] = $edited_history;
    // $record->update($data);
    // dd($record);
    // return $record;
  // }

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
