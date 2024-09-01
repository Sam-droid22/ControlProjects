<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Support\Components\ViewComponent;
use Filament\Support\Enums\ActionSize;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ProjectRevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Ingresos y Gastos';

    protected function getData(): array
    {
        $data = Transaction::select(
            DB::raw("strftime('%Y-%m', date) as month"),
            DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
            DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
        )
        ->where('date', '>=', now()->subMonths(6)->format('Y-m-d'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Ingresos',
                    'data' => $data->pluck('income'),
                    'borderColor' => '#4ade80',
                    'backgroundColor' => '#4ade80',
                ],
                [
                    'label' => 'Gastos',
                    'data' => $data->pluck('expense'),
                    'borderColor' => '#f87171',
                    'backgroundColor' => '#f87171',
                ],
            ],
            'labels' => $data->pluck('month'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFooter(): string|ViewComponent
    {
        return \Filament\Actions\Action::make('viewTransactions')
            ->label('Ver todas las transacciones')
            ->url(route('filament.admin.resources.transactions.index'))
            ->size(ActionSize::Small);
    }
}
