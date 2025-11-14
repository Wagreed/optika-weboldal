<?php

namespace App\Filament\Resources\EyeExaminationResource\Pages;

use App\Filament\Resources\EyeExaminationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEyeExamination extends EditRecord
{
    protected static string $resource = EyeExaminationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
