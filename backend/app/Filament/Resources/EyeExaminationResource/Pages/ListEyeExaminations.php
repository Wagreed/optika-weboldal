<?php

namespace App\Filament\Resources\EyeExaminationResource\Pages;

use App\Filament\Resources\EyeExaminationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEyeExaminations extends ListRecords
{
    protected static string $resource = EyeExaminationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
