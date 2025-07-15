<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatusEnum;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationGroup = 'Shop';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function getNavigationBadge(): ?string
    {
        return  static::getModel()::where('status','processing')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return  static::getModel()::where('status','processing')->count() >10 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Wizard::make([

                    Forms\Components\Wizard\Step::make('Order Details')
                        ->schema([
                            Forms\Components\TextInput::make('number')->label('Order Number')->default('ORD-' . rand(100000, 999999))->required()->disabled()->dehydrated(),
                            Forms\Components\Select::make('customer_id')->relationship('customer', 'name',
                                fn(Builder $query) => $query->limit(10)
                            )->preload()->searchable()->required(),
                            Forms\Components\Select::make('status')->options([
                                OrderStatusEnum::PENDING->value => ucfirst('pending'),
                                OrderStatusEnum::PROCESSING->value => ucfirst('processing'),
                                OrderStatusEnum::COMPLETED->value => ucfirst('completed'),
                                OrderStatusEnum::DECLINED->value => ucfirst('declined'),
                            ])->required()->columnSpanFull(),

                            Forms\Components\MarkdownEditor::make('notes')->columnSpanFull()

                        ])->columns(2),


                    Forms\Components\Wizard\Step::make('Order Items')
                        ->schema([

                            Forms\Components\Repeater::make('items')->relationship()->schema([

                                Forms\Components\Select::make('product_id')->label('Product')->options(Product::query()->pluck('name', 'id'))->searchable()->required(),
                                Forms\Components\TextInput::make('quantity')->label('Quantity')->numeric()->default(1)->required(),
                                Forms\Components\TextInput::make('unit_price')->label('Unit Price')->numeric()->disabled()->dehydrated()->required(),

                            ])->columns(3)
                        ]),


                ])->columnSpanFull()


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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

                Tables\Columns\TextColumn::make('total_price')->sortable()->searchable()->summarize([Tables\Columns\Summarizers\Sum::make()->money()]),
                Tables\Columns\TextColumn::make('created_at')->label('Order Date')->sortable()->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
