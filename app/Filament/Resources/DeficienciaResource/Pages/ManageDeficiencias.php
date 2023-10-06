<?php

namespace App\Filament\Resources\DeficienciaResource\Pages;

use App\Filament\Resources\DeficienciaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDeficiencias extends ManageRecords
{
    protected static string $resource = DeficienciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
