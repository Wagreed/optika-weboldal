<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockedDateResource\Pages;
use App\Helpers\RomanianHolidays;
use App\Models\BlockedDate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlockedDateResource extends Resource
{
    protected static ?string $model = BlockedDate::class;

    protected static ?string $navigationIcon = 'heroicon-o-no-symbol';
    protected static ?string $navigationLabel = 'Zárolt napok';
    protected static ?string $navigationGroup = 'Időpontok';
    protected static ?int $navigationSort = 20;
    protected static ?string $modelLabel = 'Zárolt nap';
    protected static ?string $pluralModelLabel = 'Zárolt napok';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Dátum'),
                Forms\Components\TextInput::make('reason')
                    ->label('Indok')
                    ->placeholder('pl. Zárva, Szabadság...')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentYear = now()->year;
        // Ünnepnapok adatainak előkészítése a táblázat alá
        $holidays = RomanianHolidays::forYear($currentYear);
        $nextHolidays = RomanianHolidays::forYear($currentYear + 1);

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->label('Dátum'),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Indok')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Létrehozva'),
            ])
            ->defaultSort('date')
            ->headerActions([
                // Ünnepnapok megtekintése gomb
                Tables\Actions\Action::make('view_holidays')
                    ->label("$currentYear-es ünnepnapok")
                    ->icon('heroicon-o-calendar')
                    ->color('info')
                    ->modalHeading("$currentYear romániai munkaszüneti napok")
                    ->modalContent(function () use ($holidays) {
                        $rows = collect($holidays)->map(fn ($name, $date) =>
                            "<tr><td style='padding:6px 12px;color:#374151'>$date</td><td style='padding:6px 12px;color:#1e3a8a;font-weight:600'>$name</td></tr>"
                        )->implode('');
                        return new \Illuminate\Support\HtmlString(
                            "<table style='width:100%;border-collapse:collapse'>$rows</table>"
                        );
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Bezárás'),
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBlockedDates::route('/'),
            'create' => Pages\CreateBlockedDate::route('/create'),
            'edit'   => Pages\EditBlockedDate::route('/{record}/edit'),
        ];
    }
}
