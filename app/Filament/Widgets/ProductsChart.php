<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Product;
use Illuminate\Support\Carbon;

class ProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Products Per Month';

    protected static ?int $sort =2;

    protected function getData(): array
    {
        // Get all products created this year (or adjust as needed)
        $products = Product::whereYear('created_at', now()->year)
            ->get()
            ->groupBy(function ($product) {
                return $product->created_at->format('Y-m');
            });

        // Fill missing months if needed
        $months = collect(range(1, 12))->map(function ($month) {
            return now()->startOfYear()->addMonths($month - 1)->format('Y-m');
        });

        $counts = $months->map(function ($month) use ($products) {
            return $products->get($month, collect())->count();
        });

        $labels = $months->map(function ($month) {
            return Carbon::createFromFormat('Y-m', $month)->format('F Y');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Products Created',
                    'data' => $counts,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
