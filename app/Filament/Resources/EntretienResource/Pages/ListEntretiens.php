<?php

namespace App\Filament\Resources\EntretienResource\Pages;

use App\Filament\Resources\EntretienResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEntretiens extends ListRecords
{
    protected static string $resource = EntretienResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
