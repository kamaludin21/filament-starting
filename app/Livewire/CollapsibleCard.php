<?php

namespace App\Livewire;

use Livewire\Component;

class CollapsibleCard extends Component
{
  protected string | Closure | null $defaultImageUrl = null;

  public function render()
  {
    return view('livewire.collapsible-card');
  }

  public function defaultImageUrl(string | Closure | null $url): static
  {
    $this->defaultImageUrl = $url;

    return $this;
  }

  public function getImageUrl(?string $state = null): ?string
  {
    if (filter_var($state, FILTER_VALIDATE_URL) !== false) {
      return $state;
    }

    /** @var FilesystemAdapter $storage */
    $storage = $this->getDisk();

    try {
      if (!$storage->exists($state)) {
        return null;
      }
    } catch (UnableToCheckFileExistence $exception) {
      return null;
    }

    if ($this->getVisibility() === 'private') {
      try {
        return $storage->temporaryUrl(
          $state,
          now()->addMinutes(5),
        );
      } catch (Throwable $exception) {
        // This driver does not support creating temporary URLs.
      }
    }

    return $storage->url($state);
  }
}
