<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PermissionResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Modules\User\Filament\Resources\PermissionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewPermission extends \Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord
{
    protected static string $resource = PermissionResource::class;

    public function getInfolistSchema(): array
    {
        return [
            TextEntry::make('name')
                ->label('Name'),
            TextEntry::make('guard_name')
                ->label('Guard Name'),
            TextEntry::make('active')
                ->label('Active')
                ->formatStateUsing(fn ($state): string => $state ? 'Yes' : 'No'),
            TextEntry::make('created_at')
                ->label('Created At')
                ->dateTime(),
        ];
    }
}
