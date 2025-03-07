<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\FeatureResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Modules\User\Filament\Resources\FeatureResource;

class EditFeature extends EditRecord
{
    protected static string $resource = FeatureResource::class;
}
