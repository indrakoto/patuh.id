<?php

namespace App\Filament\Resources\MemberhipsResource\Pages;

use App\Filament\Resources\MemberhipsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMemberhips extends EditRecord
{
    protected static string $resource = MemberhipsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
