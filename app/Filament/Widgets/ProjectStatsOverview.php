<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\ImportantDate;

class ProjectStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Proyectos Activos', Project::where('status', 'active')->count())
                ->description('Total de proyectos en curso')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('success'),

            Stat::make('Ingresos Totales', function () {
                $total = Transaction::where('type', 'income')->sum('amount');
                return 'Gs. ' . number_format($total, 0, ',', '.');
            })
                ->description('Suma de todos los ingresos')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make('Gastos Totales', function () {
                $total = Transaction::where('type', 'expense')->sum('amount');
                return 'Gs. ' . number_format($total, 0, ',', '.');
            })
                ->description('Suma de todos los gastos')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('danger'),

            Stat::make('Fechas Importantes Próximas', ImportantDate::where('date', '>=', now())
                ->where('date', '<=', now()->addDays(30))
                ->count())
                ->description('En los próximos 30 días')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),
        ];
    }
}
