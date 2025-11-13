<?php

namespace App\Filament\Resources\PlanFeatures;

use App\Filament\Resources\PlanFeatures\Pages\CreatePlanFeatures;
use App\Filament\Resources\PlanFeatures\Pages\EditPlanFeatures;
use App\Filament\Resources\PlanFeatures\Pages\ListPlanFeatures;
use App\Filament\Resources\PlanFeatures\Schemas\PlanFeaturesForm;
use App\Filament\Resources\PlanFeatures\Tables\PlanFeaturesTable;
use App\Models\PlansFeature;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanFeaturesResource extends Resource
{
    protected static ?string $model = PlansFeature::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PlanFeaturesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlanFeaturesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlanFeatures::route('/'),
            'create' => CreatePlanFeatures::route('/create'),
            'edit' => EditPlanFeatures::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
