<?php

namespace App\Filament\Resources\MostViewedResource\Pages;

use App\Filament\Resources\MostViewedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMostVieweds extends ListRecords
{
    protected static string $resource = MostViewedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
