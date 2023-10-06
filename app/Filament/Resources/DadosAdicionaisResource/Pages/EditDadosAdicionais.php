<?php

namespace App\Filament\Resources\DadosAdicionaisResource\Pages;

use App\Filament\Resources\DadosAdicionaisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDadosAdicionais extends EditRecord
{
    protected static string $resource = DadosAdicionaisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
