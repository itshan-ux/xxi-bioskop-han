<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\DatePicker;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Schedules';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('movie_id')
                ->label('Movie')
                ->relationship('movie', 'title')
                ->searchable()
                ->required(),

            Forms\Components\DatePicker::make('date')
                ->label('Date')
                ->required(),

            Forms\Components\TimePicker::make('start_time')
                ->label('Start Time')
                ->required(),

            Forms\Components\TimePicker::make('end_time')
                ->label('End Time')
                ->required()
                ->rule('after:start_time'), // Validasi: harus lebih besar dari start_time

            Forms\Components\TextInput::make('studio')
                ->label('Studio')
                ->maxLength(50)
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('movie.title')
                ->label('Movie')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('date')
                ->label('Date')
                ->date('d-m-Y'),

            Tables\Columns\TextColumn::make('start_time')
                ->label('Start Time')
                ->time('H:i'),

            Tables\Columns\TextColumn::make('end_time')
                ->label('End Time')
                ->time('H:i'),

            Tables\Columns\TextColumn::make('studio')
                ->label('Studio'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
