<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $todayAppointments = Appointment::whereDate('appointment_date', today())
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->count();

        $pendingOrders = Order::where('status', 'pending')->count();

        $newMessages = ContactMessage::where('status', 'new')->count();

        $totalCustomers = User::whereDoesntHave('roles', function ($q) {
            $q->whereIn('name', ['admin', 'super_admin', 'staff']);
        })->count();

        return [
            Stat::make('Mai időpontok', $todayAppointments)
                ->description('Foglalt és megerősített')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Függő rendelések', $pendingOrders)
                ->description('Feldolgozásra vár')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color($pendingOrders > 0 ? 'warning' : 'success'),

            Stat::make('Új üzenetek', $newMessages)
                ->description('Megválaszolatlan')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($newMessages > 0 ? 'danger' : 'success'),

            Stat::make('Ügyfelek', $totalCustomers)
                ->description('Regisztrált felhasználók')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray'),
        ];
    }
}
