<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum EditedContributor: string implements HasLabel, HasColor, HasIcon
{
  case DRAFTED = 'drafted';
  case COMPLETED = 'completed';
  case PUBLISHED = 'published';
  case ARCHIVED = 'archived';

  public function getLabel(): ?string
  {
    return match ($this) {
      self::DRAFTED => 'Draf',
      self::COMPLETED => 'Selesai',
      self::PUBLISHED => 'Publikasi',
      self::ARCHIVED => 'Arsip',
    };
  }

  public function getColor(): string|array|null
  {
    return match ($this) {
      self::DRAFTED => 'warning',
      self::COMPLETED => 'success',
      self::PUBLISHED => 'info',
      self::ARCHIVED => 'gray',
    };
  }

  public function getIcon(): ?string
  {
    return match ($this) {
      self::DRAFTED => 'heroicon-o-document',
      self::COMPLETED => 'heroicon-o-document-check',
      self::PUBLISHED => 'heroicon-o-clipboard-document-check',
      self::ARCHIVED => 'heroicon-o-archive-box',
    };
  }
}
