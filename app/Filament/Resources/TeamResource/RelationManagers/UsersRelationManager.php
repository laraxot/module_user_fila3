<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\User\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Filament\Tables;

class UsersRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $inverseRelationship = 'teams';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name'),
            'email' => TextColumn::make('email'),
            'role' => TextColumn::make('role'),
        ];
    }
    
    public function getTableHeaderActions(): array
    {
        return [
            Tables\Actions\AttachAction::make(),
        ];
    }
    
    public function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DetachAction::make(),
            Tables\Actions\DeleteAction::make(),
        ];
    }
    
    public function getTableBulkActions(): array
    {
        return [
            Tables\Actions\DetachBulkAction::make(),
            Tables\Actions\DeleteBulkAction::make(),
        ];
    }
}
