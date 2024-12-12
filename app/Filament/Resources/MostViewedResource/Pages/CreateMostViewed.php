<?php

namespace App\Filament\Resources\MostViewedResource\Pages;

use App\Filament\Resources\MostViewedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

// make the redis empty for
Cache::forget('most_viewed_items');

class CreateMostViewed extends CreateRecord
{
    protected static string $resource = MostViewedResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Item Add to Most Viewed';
    }
    
}
