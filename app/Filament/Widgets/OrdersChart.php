<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Orders by Status';

    protected static ?int $sort =3;
    protected function getData(): array
    {
        // Get all orders and group by status
        $orders = Order::all()->groupBy('status');

        // Map to counts
        $statusCounts = $orders->map(function ($items, $status) {
            return [
                'status' => $status,
                'count' => $items->count(),
            ];
        })->values();

        // Separate labels and counts
        $labels = $statusCounts->pluck('status');
        $counts = $statusCounts->pluck('count');

        return [
            'datasets' => [
                [
                    'label' => 'Order Count',
                    'data' => $counts,
                    'backgroundColor' => '#178991',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
