<?php

namespace App\Filament\Resources\FanPhotoResource\Pages;

use Filament\Actions;
use App\Models\FanPhoto;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\FanPhotoResource;

class ListFanPhotos extends ListRecords
{
    protected static string $resource = FanPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'Approved' => ListRecords\Tab::make()->query(fn($query) => FanPhoto::where('status', 'approved')),
            'Draft' => ListRecords\Tab::make()->query(fn($query) => FanPhoto::where('status', 'draft')),
            'Rejected' => ListRecords\Tab::make()->query(fn($query) => FanPhoto::where('status', 'rejected')),

            //null => ListRecords\Tab::make('All')
        ];
    }
}
