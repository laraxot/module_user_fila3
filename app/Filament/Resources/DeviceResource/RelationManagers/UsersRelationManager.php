<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\DeviceResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Modules\User\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;









class UsersRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'users';

    public function getFormSchema(): array
{
    
        
    return [
              
                    TextInput::make('device')
                        ->required()
                        ->maxLength(255),
                
      ];
}

    public function table(Table $table): Table
    {
        $table = UserResource::table($table);

        return $table;
    }
}
