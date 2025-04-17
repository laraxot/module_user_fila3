<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;









class ProfileRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'profile';

    protected static ?string $recordTitleAttribute = 'first_name';

    public function getFormSchema(): array
{
    
        
    return [
              
                    TextInput::make('ente'),
                    TextInput::make('matr'),
                    TextInput::make('first_name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('last_name'),
                
      ];
}

    public function table(Table $table): Table
    {
        return $table
            ->columns(
                [
                    TextColumn::make('id'),
                    TextColumn::make('ente'),
                    TextColumn::make('matr'),
                    TextColumn::make('first_name'),
                    TextColumn::make('last_name'),
                ]
            )
            ->filters(
                [
                ]
            )
            ->headerActions(
                [
                    CreateAction::make(),
                ]
            )
            ->actions(
                [
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]
            )
            ->bulkActions(
                [
                    DeleteBulkAction::make(),
                ]
            );
    }
}
