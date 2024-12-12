<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Controlling of Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                ->minLength(5)
                    ->maxLength(300)
                    ->required(),
                FileUpload::make('cover_image')
                ->image()
                    ->imageEditor()
                    ->directory('items')
                    ->visibility('public')
                    ->storeFileNamesIn('cover_image_path')
                    ->getUploadedFileNameForStorageUsing(
                        fn(TemporaryUploadedFile $file): string => (string) str('custom-prefix-' . $file->getClientOriginalName())
                            ->prepend('items/')
                    ),
                TextInput::make('author_or_guest')
                ->minLength(5)
                    ->maxLength(100)
                    ->required(),
                TextInput::make('release_year')
                ->minLength(2)
                    ->maxLength(4)
                    ->required(),
                TextInput::make('short_summary')
                ->minLength(5)
                    ->maxLength(1000)
                    ->required(),
                MarkdownEditor::make('detailed_summary')
                ->toolbarButtons([
                    'attachFiles',
                    'blockquote',
                    'bold',
                    'bulletList',
                    'codeBlock',
                    'heading',
                    'italic',
                    'link',
                    'orderedList',
                    'redo',
                    'strike',
                    'table',
                    'undo',
                ]),
                Select::make('section_id')
                ->relationship('section', 'name')
                ->preload()
                    ->required(),
                Select::make('tags')
                ->label('Tags')
                ->multiple()
                    ->relationship('tags', 'name')
                    ->preload(),
                Select::make('categories')
                ->label('Categories')
                ->multiple()
                    ->relationship('categories', 'name')
                    ->preload(),
            ])->columns(2);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable(),
                ImageColumn::make('cover_image')
                ->circular()
                    ->disk('public'),
                TextColumn::make('short_summary')
                ->limit(30)
                    ->tooltip(fn($record) => $record->short_summary),
                TextColumn::make('section.name')
                ->label('Section')
                ->searchable(),
                TextColumn::make('tags.name')
                ->label('Tags')
                ->limit(3)
                    ->tooltip(fn($record) => $record->tags->pluck('name')->join(', ')),
                TextColumn::make('categories.name')
                ->label('Categories')
                ->limit(3)
                    ->tooltip(fn($record) => $record->categories->pluck('name')->join(', ')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
