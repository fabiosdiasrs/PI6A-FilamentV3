<?php

namespace App\Filament\Resources\DadosAdicionaisResource\Pages;

use App\Filament\Resources\DadosAdicionaisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDadosAdicionais extends ListRecords
{
    protected static string $resource = DadosAdicionaisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
