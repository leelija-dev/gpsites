<?php

namespace App\Filament\Resources\Plans\Pages;

use App\Filament\Resources\Plans\PlansResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\PlansFeature;

class CreatePlans extends CreateRecord
{
    protected static string $resource = PlansResource::class;

      protected function afterCreate(): void
    {
        $data = $this->form->getState();

        if (!empty($data['features'])) {
            foreach ($data['features'] as $featureData) {
                PlansFeature::create([
                    'plan_id' => $this->record->id,
                    'feature' => $featureData['feature'],
                ]);
            }
        }
    }
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
