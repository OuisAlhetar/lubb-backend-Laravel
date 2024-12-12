<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MostViewedResource\Pages;
use App\Models\MostViewed;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MostViewedResource extends Resource
{
    protected static ?string $model = MostViewed::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-thumb-up';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Controlling of Content';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Select::make('item_id')
                ->label('Item')
                ->relationship('item', 'title') // Assumes the Item model has a `title` field
                ->preload()
                ->searchable()
                ->required(),
            TextInput::make('view_count')
                ->label('View Count')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('item.title')
                ->label('Item Title')
                ->sortable()
                ->searchable(),
            TextColumn::make('view_count')
                ->label('View Count')
                ->sortable(),
            TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMostVieweds::route('/'),
            'create' => Pages\CreateMostViewed::route('/create'),
            'edit' => Pages\EditMostViewed::route('/{record}/edit'),
        ];
    }
}
