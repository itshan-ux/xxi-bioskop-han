<?php

namespace App\Filament\Resources;

use App\Models\Ticket;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Filament\Resources\TicketResource\Pages;
use Carbon\Carbon;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Tickets';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('schedule_id')
                ->label('Schedule')
                ->relationship('schedule', 'id')
                ->getOptionLabelFromRecordUsing(fn ($record) => 
                    $record->movie->title 
                    . ' | ' 
                    . Carbon::parse($record->date)->format('d M Y') 
                    . ' ' 
                    . Carbon::parse($record->start_time)->format('H:i')
                )
                //->searchable()
                ->required(),

            Forms\Components\TextInput::make('customer_name')
                ->label('Customer Name')
                ->required(),

            Forms\Components\TextInput::make('seat_number')
                ->label('Seat Number')
                ->required()
                ->rule('regex:/^[A-Z]\d{1,2}$/') // ✅ format 1 huruf + 1-2 angka
                ->unique(
                    ignoreRecord: true, 
                    modifyRuleUsing: fn (\Illuminate\Validation\Rules\Unique $rule, callable $get) 
                        => $rule->where('schedule_id', $get('schedule_id'))
                )
                ->helperText('Format kursi contoh: A1, B12, F9'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('schedule.movie.title')
                    ->label('Movie'),

                Tables\Columns\TextColumn::make('schedule.date')
                    ->label('Show Date')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('schedule.start_time')
                    ->label('Start Time')
                    ->time('H:i'),

                Tables\Columns\TextColumn::make('schedule.studio')
                    ->label('Studio'),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer'),

                Tables\Columns\TextColumn::make('seat_number')
                    ->label('Seat'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Purchased At')
                    ->dateTime('d M Y H:i'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
