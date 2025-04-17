<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Pages\Actions\ViewAction;
use Modules\User\Filament\Resources\TeamResource;




use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;





class EditTeam extends \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
{
    // //
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
