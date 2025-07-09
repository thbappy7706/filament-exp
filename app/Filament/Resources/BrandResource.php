<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ColorPicker;
use Illuminate\Support\Str;


class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;
    protected static ?string $navigationGroup = 'Shop';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Brand ')
                    ->schema([
                        TextInput::make('name')->required()->maxLength(255) ->live(onBlur:  true)->unique()
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')->disabled()->dehydrated()->required()->unique(),
                        TextInput::make('url')->label('Website URL')->unique()->required()->columnSpanFull()->url(),
                        ColorPicker::make('primary_hex')->label('Primary HEX Color')->columnSpanFull(),
                        Toggle::make('is_visible')->label('Is Visible')->columnSpanFull(),
                        MarkdownEditor::make('description')->label('Description')->maxLength(65535)->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('url')->label('Website Url')->sortable()->searchable(),
                TextColumn::make('url')
                    ->label('Website URL')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn (string $state) => str($state)->limit(30)) // limit the text
                    ->extraAttributes(fn ($record) => [
                        'title' => $record->url,
                        'onclick' => "window.open('{$record->url}', '_blank')",
                        'class' => 'text-primary underline cursor-pointer',
                    ]),
                Tables\Columns\ColorColumn::make('primary_hex')->label('Color')->sortable()->searchable(),
                Tables\Columns\IconColumn::make('is_visible')->label('Visibility')->boolean()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->sortable()->date(),
            ])
            ->filters([
                //
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
            'index' => Pages\ManageBrands::route('/'),

        ];
    }
}
