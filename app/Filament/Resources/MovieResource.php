<?php

namespace App\Filament\Resources;

use App\Models\Movie;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Filament\Resources\MovieResource\Pages;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;
    protected static ?string $navigationIcon = 'heroicon-o-film';
    protected static ?string $navigationLabel = 'Movies';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('genre')->required(),
            Forms\Components\TextInput::make('duration')
                ->numeric()
                ->suffix(' menit'),
            Forms\Components\Textarea::make('description'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('genre'),
                Tables\Columns\TextColumn::make('duration')->label('Durasi (menit)'),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->date(),
                Tables\Columns\TextColumn::make('description')->limit(30),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }
}
