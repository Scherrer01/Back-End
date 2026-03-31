<?php

namespace App\Filament\Resources\Estoques;

use App\Filament\Resources\Estoques\Pages\CreateEstoque;
use App\Filament\Resources\Estoques\Pages\EditEstoque;
use App\Filament\Resources\Estoques\Pages\ListEstoques;
use App\Filament\Resources\Estoques\Pages\ViewEstoque;
use App\Filament\Resources\Estoques\Schemas\EstoqueForm;
use App\Filament\Resources\Estoques\Schemas\EstoqueInfolist;
use App\Filament\Resources\Estoques\Tables\EstoquesTable;
use App\Models\Estoque;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use BackedEnum;
use Filament\Support\RawJs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EstoqueResource extends Resource
{
    protected static ?string $model = Estoque::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Estoque';

    public static function form(Schema $schema): Schema
    {
        // return EstoqueForm::configure($schema);
        return $schema
        ->schema([
            Select::make('produto_id')
                ->relationship('produto', 'nome')
                ->searchable()
                ->preload()
                ->required()
                ->label('Produto')
                ->live()
                ->afterStateUpdated(function ($state, Set $set) {
                    if ($state) {
                        $produto = \App\Models\Produto::find($state);
                        if ($produto) {
                            $set('produto_nome', $produto->nome);
                            $set('produto_preco', $produto->preco);
                        }
                    }
                }),

            TextInput::make('quantidade')
                ->numeric()
                ->required()
                ->label('Quantidade'),

            TextInput::make('quantidade_minima')
                ->numeric()
                ->label('Quantidade Mínima'),

            TextInput::make('quantidade_maxima')
                ->numeric()
                ->label('Quantidade Máxima'),

            Select::make('status')
                ->options([
                    'disponivel' => 'Disponível',
                    'baixo_estoque' => 'Baixo Estoque',
                    'esgotado' => 'Esgotado',
                ])
                ->default('Disponivel')
                ->required(),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EstoqueInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('produto.nome')
                    ->label('Produto')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('produto.preco')
                    ->label('Preço')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('quantidade')
                    ->label('Quantidade em Estoque')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('quantidade_minima')
                    ->label('Mínimo')
                    ->numeric(),

                TextColumn::make('quantidade_maxima')
                    ->label('Máximo')
                    ->numeric(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'disponivel' => 'success',
                        'baixo_estoque' => 'warning',
                        'esgotado' => 'danger',
                        default => 'blue',
                    }),
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
            'index' => ListEstoques::route('/'),
            'create' => CreateEstoque::route('/create'),
            'view' => ViewEstoque::route('/{record}'),
            'edit' => EditEstoque::route('/{record}/edit'),
        ];
    }
}