<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\BaseProfileResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Modules\User\Filament\Resources\BaseProfileResource;

class EditProfile extends EditRecord
{
    protected static string $resource = BaseProfileResource::class;
}
