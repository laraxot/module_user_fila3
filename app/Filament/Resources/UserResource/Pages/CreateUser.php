<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Modules\User\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class CreateUser extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
{
    // //
    protected static string $resource = UserResource::class;
}
