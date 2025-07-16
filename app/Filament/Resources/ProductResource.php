<?php

namespace App\Filament\Resources;

use App\Enums\ProductTypeEnum;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?int $navigationSort = 0;
    protected static ?string $navigationGroup = 'Shop';

    public static function getNavigationBadge(): ?string
    {
        return  static::getModel()::count();
    }

    protected static ?string $recordTitleAttribute = 'name';
    protected static int $globalSearchResultsLimit = 20;


    public static function getGloballySearchableAttributes(): array
    {
        return  ['name','slug','description'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
          'Brand' => $record->brand->name,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['brand']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Basic Information')->schema([
                        Forms\Components\TextInput::make('name')->required()
                            ->live(onBlur: true)->unique()
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')->disabled()->dehydrated()->unique(Product::class, 'slug', ignoreRecord: true),
                        Forms\Components\MarkdownEditor::make('description')->columnSpan('full'),

                    ])->columns(2),


                    Forms\Components\Section::make('Pricing & Inventory')->schema([
                        Forms\Components\TextInput::make('sku')->label("SKU (Stock Keeping Unit)")->required()->unique(),
                        Forms\Components\TextInput::make('price')
                            ->numeric()->rules([
                                'regex:/^\d+(\.\d{1,2})?$/'
                            ])->required(),
                        Forms\Components\TextInput::make('quantity')->numeric()->minValue(0)->maxValue(100)->required(),
                        Forms\Components\Select::make('type')->options([
                            'downloadable' => ProductTypeEnum::DOWNLOADABLE->value,
                            'deliverable' => ProductTypeEnum::DELIVERABLE->value,
                        ])->required(),

                    ])->columns(2)

                ]),


                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Status')->schema([
                        Forms\Components\Toggle::make('is_visible')
                            ->label('Visibility')->helperText('Enable or disable product visibility.')->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured')->helperText('Enable or disable product featured.')->default(true),

                        DatePicker::make('published_at')->label('Availability')->default(now()),
                    ]),
                    Forms\Components\Section::make('Image')->schema([
                        Forms\Components\FileUpload::make('image')
                            ->directory('product-attachments')->preserveFilenames()
                            ->image()->imageEditor(),

                    ])->collapsible(),


                    Forms\Components\Section::make('Associations')->schema([
                        Forms\Components\Select::make('brand_id')->relationship('brand', 'name')->preload()->searchable()->required(),
                        Forms\Components\Select::make('categories')->relationship('categories', 'name')->preload()->multiple()->searchable()->required(),

                    ]),

                ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('brand.name')->searchable()->sortable()->toggleable(),
                Tables\Columns\IconColumn::make('is_visible')->label('Visibility')->boolean()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('published_at')->date()->sortable(),
                Tables\Columns\TextColumn::make('type'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_visible')->label('Visibility')->boolean()
                    ->trueLabel('Only Visible')->falseLabel('Only Hidden')->native(false),
                Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name')->preload()->searchable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
