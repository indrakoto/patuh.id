<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

    protected static ?string $navigationLabel   = 'Dokumen ';
    protected ?string $heading      = 'Dokumen';    
    protected ?string $subheading   = 'Daftar Dokumen';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Dokumen')
                ->createAnother(false)
                ->modalSubmitActionLabel('SIMPAN')
                ->modalHeading('Tambah Dokumen'),
        ];
    }
}
