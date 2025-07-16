<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{

    protected static ?string $pollingInterval = '15s';
    protected function getStats(): array
    {
        return [
           Stat::make('Total Customers', Customer::count())
               ->description('Increase in customers')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')->chart([7,3,4,5,6,3,5,3]),



            Stat::make('Total Products', Product::count())
                ->description('Total products in app')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')->chart([7,3,4,5,6,3,5,3]),


            Stat::make('Pending Order', Order::where('status', 'pending')->count())
                ->description('Pending Orders in app')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('warning')->chart([7,3,4,5,6,3,5,3]),


        ];
    }
}
