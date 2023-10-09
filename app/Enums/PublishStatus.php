<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum PublishStatus: string implements HasLabel, HasColor, HasIcon
{
  case QUEUE = 'queue';
  case PREVIEW = 'preview';
  case HOLD = 'hold';
  case PUBLISH = 'publish';

  public function getLabel(): ?string
  {
    return match ($this) {
      self::QUEUE => 'Antrian',
      self::PREVIEW => 'Pemeriksaan',
      self::HOLD => 'Ditahan',
      self::PUBLISH => 'Diterbitkan'
    };
  }

  public function getColor(): string|array|null
  {
    return match ($this) {
      self::QUEUE => 'gray',
      self::PREVIEW => 'primary',
      self::HOLD => 'warning',
      self::PUBLISH => 'success',
    };
  }

  public function getIcon(): ?string
  {
    return match ($this) {
      self::QUEUE => 'heroicon-o-minus-circle',
      self::PREVIEW => 'heroicon-o-arrow-up-circle',
      self::HOLD => 'heroicon-o-exclamation-circle',
      self::PUBLISH => 'heroicon-o-check-circle',
    };
  }
}
