<?php

namespace App\Filament\Resources\PlanFeatures\Pages;

use App\Filament\Resources\PlanFeatures\PlanFeaturesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlanFeatures extends ListRecords
{
    protected static string $resource = PlanFeaturesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
