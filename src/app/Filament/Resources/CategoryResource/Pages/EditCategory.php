<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected ?string $heading      = 'Kategori';

    protected ?string $subheading   = 'Edit Kategori';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('kembali')
                ->label('Kembali ke List')
                ->url($this->getResource()::getUrl()) // Mengarahkan ke halaman List resource
                //->color('secondary'), // Opsional: memberi warna pada tombol
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSubmitFormAction()->label('SIMPAN'),
            $this->getCancelFormAction()->label('BATAL'),
        ];
    }
}
