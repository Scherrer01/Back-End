<?php

namespace App\Filament\Resources\Produtos;

use App\Filament\Resources\Produtos\Pages\CreateProduto;
use App\Filament\Resources\Produtos\Pages\EditProduto;
use App\Filament\Resources\Produtos\Pages\ListProdutos;
use App\Filament\Resources\Produtos\Pages\ViewProduto;
use App\Models\Produto;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProdutoResource extends Resource
{
    protected static ?string $model = Produto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?string $recordTitleAttribute = 'Produtos';

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->schema([
            TextInput::make('nome')->required()->label('Nome do Produto'),
            TextInput::make('referecia')->label('Referência')->nullable(),
            TextInput::make('preco_venda')
                ->label('Preço de Venda')
                ->prefix('R$')
                ->numeric()
                ->nullable()
                ->inputMode('decimal')
                ->step(0.01)
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2, ',', '.') : null)
                ->dehydrateStateUsing(fn ($state) => $state ? str_replace(',', '.', str_replace('.', '', $state)) : null),
            TextInput::make('estoque')
                ->label('Estoque')
                ->numeric()
                ->default(0)
                ->integer(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('nome')->searchable(),
            TextColumn::make('referecia')->label('Referência')->searchable(),
            TextColumn::make('preco_venda')
                ->label('Preço Venda')
                ->money('BRL')
                ->sortable(),
            TextColumn::make('estoque')
                ->label('Estoque')
                ->numeric()
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
            'index' => ListProdutos::route('/'),
            'create' => CreateProduto::route('/create'),
            'view' => ViewProduto::route('/{record}'),
            'edit' => EditProduto::route('/{record}/edit'),
        ];
    }
}