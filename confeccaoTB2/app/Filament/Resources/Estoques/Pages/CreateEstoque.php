<?php

namespace App\Filament\Resources\Estoques\Pages;

use App\Filament\Resources\Estoques\EstoqueResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEstoque extends CreateRecord
{
    protected static string $resource = EstoqueResource::class;

    protected function afterCreate(): void {
        $estoque = $this->record;
        
        // Atualiza o status baseado na quantidade
        if ($estoque->quantidade <= 0) {
            $estoque->update(['status' => 'esgotado']);
        } elseif ($estoque->quantidade <= $estoque->quantidade_minima) {
            $estoque->update(['status' => 'baixo_estoque']);
        } else {
            $estoque->update(['status' => 'disponivel']);
        }
    }
}