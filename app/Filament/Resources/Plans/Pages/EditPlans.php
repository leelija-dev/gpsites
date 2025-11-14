<?php

namespace App\Filament\Resources\Plans\Pages;

use App\Filament\Resources\Plans\PlansResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use App\Models\PlansFeature;

class EditPlans extends EditRecord
{
    protected static string $resource = PlansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    /**
     * ✅ Pre-fill the repeater with existing features
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['features'] = $this->record->features
            ? $this->record->features->map(fn($feature) => [
                'id' => $feature->id,
                'feature' => $feature->feature,
            ])->toArray()
            : [];

        return $data;
    }

    /**
     * ✅ Update features on save (add / update / delete)
     */
    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $features = $data['features'] ?? [];

        // Fetch existing IDs from DB
        $existingFeatureIds = $this->record->features()->pluck('id')->toArray();

        // Track which IDs we keep
        $keptFeatureIds = [];

        foreach ($features as $featureData) {
            if (!empty($featureData['id'])) {
                // Update existing feature
                $feature = \App\Models\PlansFeature::find($featureData['id']);
                if ($feature) {
                    $feature->update([
                        'feature' => $featureData['feature'],
                    ]);
                    $keptFeatureIds[] = $feature->id;
                }
            } else {
                // Create new feature
                $newFeature = \App\Models\PlansFeature::create([
                    'plan_id' => $this->record->id,
                    'feature' => $featureData['feature'],
                ]);
                $keptFeatureIds[] = $newFeature->id;
            }
        }

        // ✅ Delete removed features
        $featuresToDelete = array_diff($existingFeatureIds, $keptFeatureIds);

        if (!empty($featuresToDelete)) {
            \App\Models\PlansFeature::whereIn('id', $featuresToDelete)->delete();
        }
    }
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
