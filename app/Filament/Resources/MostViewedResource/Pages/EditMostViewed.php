<?php

namespace App\Filament\Resources\MostViewedResource\Pages;

use App\Filament\Resources\MostViewedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;

// make the redis empty for
Cache::forget('most_viewed_items');

class EditMostViewed extends EditRecord
{
    protected static string $resource = MostViewedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Updated the Most Veiwed Item';
    }
}
