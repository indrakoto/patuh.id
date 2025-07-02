<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected static ?string $navigationLabel   = 'Kategori ';
    protected ?string $heading      = 'Kategori';    
    protected ?string $subheading   = 'Daftar Kategori';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Kategori')
                ->createAnother(false)
                ->modalSubmitActionLabel('SIMPAN')
                ->modalHeading('Tambah Kategori'),
        ];
    }
}
