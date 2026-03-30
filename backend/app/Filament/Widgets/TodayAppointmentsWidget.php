<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TodayAppointmentsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Mai időpontok';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()
                    ->whereDate('appointment_date', today())
                    ->orderBy('start_time')
            )
            ->columns([
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Időpont'),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Kliens'),
                Tables\Columns\TextColumn::make('staff.name')
                    ->label('Munkatárs'),
                Tables\Columns\TextColumn::make('appointmentType.name')
                    ->label('Típus'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'scheduled',
                        'primary' => 'confirmed',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                        'secondary' => 'no_show',
                    ])
                    ->label('Státusz'),
                Tables\Columns\TextColumn::make('price')
                    ->money('RON')
                    ->label('Ár'),
            ])
            ->emptyStateHeading('Nincsenek mai időpontok')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}
