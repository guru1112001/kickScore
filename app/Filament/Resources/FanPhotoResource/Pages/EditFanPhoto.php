<?php

namespace App\Filament\Resources\FanPhotoResource\Pages;

use App\Filament\Resources\FanPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFanPhoto extends EditRecord
{
    protected static string $resource = FanPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
