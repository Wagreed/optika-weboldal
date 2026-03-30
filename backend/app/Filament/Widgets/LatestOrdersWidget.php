<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Legújabb rendelések';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->latest('ordered_at')
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Rendelésszám'),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Vásárló'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'processing',
                        'info' => 'ready',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->label('Státusz'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money('RON')
                    ->label('Végösszeg'),
                Tables\Columns\TextColumn::make('ordered_at')
                    ->dateTime('Y-m-d H:i')
                    ->label('Dátum'),
            ])
            ->emptyStateHeading('Nincsenek rendelések')
            ->emptyStateIcon('heroicon-o-shopping-bag');
    }
}
