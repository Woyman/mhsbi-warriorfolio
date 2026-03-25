<?php

namespace App\Filament\Resources\ExperienceResource\Pages;

use App\Filament\Resources\ExperienceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExperiences extends ListRecords
{
    protected static string $resource = ExperienceResource::class;

    protected static ?string $title = 'Experience';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('New Experience'))
                ->size('sm')
                ->icon('heroicon-o-briefcase'),
        ];
    }
}
