<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum EditedStatus: string implements HasLabel, HasColor, HasIcon
{
  case DRAFTED = 'drafted';
  case COMPLETED = 'completed';

  public function getLabel(): ?string
  {
    return match($this)
    {
      self::DRAFTED => 'Draf',
      self::COMPLETED => 'Selesai',
    };
  }

  public function getColor(): string|array|null
  {
    return match($this)
    {
      self::DRAFTED => 'warning',
      self::COMPLETED => 'success',
    };
  }

  public function getIcon(): ?string
  {
    return match($this)
    {
      self::DRAFTED => 'heroicon-o-document',
      self::COMPLETED => 'heroicon-o-document-check',
    };
  }
}
