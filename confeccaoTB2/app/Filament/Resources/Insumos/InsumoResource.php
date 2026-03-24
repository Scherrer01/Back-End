<?php

namespace App\Filament\Resources\Insumos;

use App\Filament\Resources\Insumos\Pages\CreateInsumo;
use App\Filament\Resources\Insumos\Pages\EditInsumo;
use App\Filament\Resources\Insumos\Pages\ListInsumos;
use App\Filament\Resources\Insumos\Pages\ViewInsumo;
use App\Models\Insumo;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InsumoResource extends Resource
{
    protected static ?string $model = Insumo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static ?string $recordTitleAttribute = 'Insumos';

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->schema([
            TextInput::make('nome')->required()->label('Nome do Insumo'),
            TextInput::make('unidade_medida')->required()->label('Unidade de Medida'),
            TextInput::make('preco_custo')
                ->required()
                ->label('Preço de Custo')
                ->prefix('R$')
                ->numeric()
                ->inputMode('decimal')
                ->step(0.01)
                ->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.'))
                ->dehydrateStateUsing(fn ($state) => str_replace(',', '.', str_replace('.', '', $state))),
            TextInput::make('estoque')
                ->label('Estoque')
                ->numeric()
                ->default(0)
                ->step(0.01),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('nome')->searchable(),
            TextColumn::make('unidade_medida')->label('Unidade'),
            TextColumn::make('preco_custo')
                ->label('Preço Custo')
                ->money('BRL')
                ->sortable(),
            TextColumn::make('estoque')
                ->label('Estoque')
                ->numeric(decimalPlaces: 2)
                ->sortable(),
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
            'index' => ListInsumos::route('/'),
            'create' => CreateInsumo::route('/create'),
            'view' => ViewInsumo::route('/{record}'),
            'edit' => EditInsumo::route('/{record}/edit'),
        ];
    }
}