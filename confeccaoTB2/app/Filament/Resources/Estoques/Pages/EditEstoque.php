<?php

namespace App\Filament\Resources\Estoques\Pages;

use App\Filament\Resources\Estoques\EstoqueResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEstoque extends EditRecord
{
    protected static string $resource = EstoqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void {
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