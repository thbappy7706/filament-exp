<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort =4;


    public function table(Table $table): Table
    {
        return $table
            ->query(
               OrderResource::getEloquentQuery()
            )->defaultPaginationPageOption(5)->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('number')->sortable()->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('customer.name')->sortable()->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'processing' => 'warning',
                        'completed' => 'success',
                        'declined' => 'danger',
                    })->formatStateUsing(fn(string $state): string => ucfirst($state))->sortable()->searchable(),

                Tables\Columns\TextColumn::make('created_at')->label('Order Date')->sortable()->date(),
            ]);
    }
}
