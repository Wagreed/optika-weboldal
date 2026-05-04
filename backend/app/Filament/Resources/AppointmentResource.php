<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Mail\AppointmentConfirmedMail;
use App\Mail\AppointmentRejectedMail;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Időpontok';
    protected static ?string $navigationGroup = 'Időpontok';
    protected static ?int $navigationSort = 10;
    protected static ?string $modelLabel = 'Időpont';
    protected static ?string $pluralModelLabel = 'Időpontok';

    public static function getNavigationBadge(): ?string
    {
        $pendingCount = Appointment::where('status', 'pending')->count();
        return $pendingCount > 0 ? (string) $pendingCount : null;
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Időpont adatai')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Regisztrált ügyfél'),
                        Forms\Components\TextInput::make('guest_name')
                            ->label('Vendég neve')
                            ->nullable()
                            ->visible(fn (Forms\Get $get) => ! $get('customer_id')),
                        Forms\Components\TextInput::make('guest_email')
                            ->label('Vendég email')
                            ->email()
                            ->nullable()
                            ->visible(fn (Forms\Get $get) => ! $get('customer_id')),
                        Forms\Components\Select::make('staff_id')
                            ->relationship('staff', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Munkatárs'),
                        Forms\Components\Select::make('appointment_type_id')
                            ->relationship('appointmentType', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Időpont típusa'),
                        Forms\Components\DatePicker::make('appointment_date')
                            ->required()
                            ->label('Dátum'),
                        Forms\Components\TextInput::make('start_time')
                            ->nullable()
                            ->label('Kezdés'),
                        Forms\Components\TextInput::make('end_time')
                            ->nullable()
                            ->label('Befejezés'),
                    ])->columns(2),

                Forms\Components\Section::make('Státusz & Ár')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending'     => 'Függőben (új kérés)',
                                'scheduled'   => 'Foglalva',
                                'confirmed'   => 'Megerősítve',
                                'completed'   => 'Befejezve',
                                'cancelled'   => 'Törölve',
                                'no_show'     => 'Nem jelent meg',
                            ])
                            ->required()
                            ->label('Státusz'),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('RON')
                            ->label('Ár'),
                        Forms\Components\Toggle::make('reminder_sent')
                            ->label('Emlékeztető elküldve'),
                        Forms\Components\DateTimePicker::make('cancelled_at')
                            ->label('Lemondva'),
                    ])->columns(2),

                Forms\Components\Section::make('Megjegyzések')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Általános jegyzetek')
                            ->rows(3),
                        Forms\Components\Textarea::make('customer_notes')
                            ->label('Ügyfél megjegyzései')
                            ->rows(3),
                        Forms\Components\Textarea::make('internal_notes')
                            ->label('Belső jegyzetek')
                            ->rows(3),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('appointment_date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->label('Dátum'),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Időpont'),
                Tables\Columns\TextColumn::make('contact_name')
                    ->label('Ügyfél')
                    ->getStateUsing(fn (Appointment $record) => $record->getContactName())
                    ->searchable(query: fn ($query, $search) => $query
                        ->where(fn ($q) => $q
                            ->whereHas('customer', fn ($q2) => $q2->where('name', 'like', "%{$search}%"))
                            ->orWhere('guest_name', 'like', "%{$search}%")
                        )
                    ),
                Tables\Columns\TextColumn::make('contact_email')
                    ->label('Email')
                    ->getStateUsing(fn (Appointment $record) => $record->getContactEmail())
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('appointmentType.name')
                    ->searchable()
                    ->sortable()
                    ->label('Típus'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pending'     => 'warning',
                        'scheduled'   => 'info',
                        'confirmed'   => 'primary',
                        'completed'   => 'success',
                        'cancelled'   => 'danger',
                        'no_show'     => 'gray',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending'     => 'Függőben',
                        'scheduled'   => 'Foglalva',
                        'confirmed'   => 'Megerősítve',
                        'completed'   => 'Befejezve',
                        'cancelled'   => 'Törölve',
                        'no_show'     => 'Nem jelent meg',
                        default       => $state,
                    })
                    ->label('Státusz'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->label('Beérkezett')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('appointment_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'   => 'Függőben',
                        'scheduled' => 'Foglalva',
                        'confirmed' => 'Megerősítve',
                        'completed' => 'Befejezve',
                        'cancelled' => 'Törölve',
                        'no_show'   => 'Nem jelent meg',
                    ])
                    ->label('Státusz'),
            ])
            ->actions([
                // Elfogad akció: 'pending' státuszú időpontokon jelenik meg
                Tables\Actions\Action::make('confirm')
                    ->label('Elfogad')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Appointment $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Időpont elfogadása')
                    ->modalDescription(fn (Appointment $record) => "Biztosan elfogadja {$record->getContactName()} időpont kérését?")
                    ->modalSubmitActionLabel('Igen, elfogadom')
                    ->action(function (Appointment $record): void {
                        $record->update(['status' => 'confirmed']);

                        $email = $record->getContactEmail();
                        if ($email) {
                            Mail::to($email)->send(
                                new AppointmentConfirmedMail($record, $record->getContactName())
                            );
                        }

                        Notification::make()
                            ->title('Időpont elfogadva')
                            ->body('Visszaigazoló email elküldve.')
                            ->success()
                            ->send();
                    }),

                // Elutasít akció: indoklás megadásával
                Tables\Actions\Action::make('reject')
                    ->label('Elutasít')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Appointment $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('reason')
                            ->label('Elutasítás indoklása (opcionális)')
                            ->rows(3),
                    ])
                    ->modalHeading('Időpont elutasítása')
                    ->modalSubmitActionLabel('Elutasítom')
                    ->action(function (Appointment $record, array $data): void {
                        $record->update([
                            'status'       => 'cancelled',
                            'cancelled_at' => now(),
                        ]);

                        $email = $record->getContactEmail();
                        if ($email) {
                            Mail::to($email)->send(
                                new AppointmentRejectedMail($record, $record->getContactName(), $data['reason'] ?? null)
                            );
                        }

                        Notification::make()
                            ->title('Időpont elutasítva')
                            ->body('Értesítő email elküldve.')
                            ->warning()
                            ->send();
                    }),

                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit'   => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
