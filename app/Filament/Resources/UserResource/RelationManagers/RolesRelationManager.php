<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;









class RolesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $recordTitleAttribute = 'name';

    // protected static ?string $inverseRelationship = 'section'; // Since the inverse related model is `Category`, this is normally `category`, not `section`.

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //
    // }

    public function getFormSchema(): array
{
    
        
    return [
              
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    /*
                Forms\Components\Select::make('team_id')
                    ->relationship('teams', 'name'),
                */
                
      ];
}

    public function table(Table $table): Table
    {
        $xotData = XotData::make();

        return $table
            ->columns(
                [
                    TextColumn::make('id'),
                    TextColumn::make('name'),
                    TextColumn::make('team_id'),
                ]
            )
            ->filters(
                [
                ]
            )
            ->headerActions(
                [
                    // Tables\Actions\CreateAction::make(),
                    AttachAction::make()
                        // ->mutateFormDataUsing(function (array $data): array {
                        //     // This is the test.
                        //     $data['team_id'] = 2;
                        //     return $data;
                        // }),
                        ->form(
                            static fn (AttachAction $action): array => [
                                $action->getRecordSelect(),
                                // Forms\Components\TextInput::make('team_id')->required(),
                                Select::make('team_id')
                                    ->options($xotData->getTeamClass()::get()->pluck('name', 'id')),
                                // ->options(function($item){
                                //     dddx($this);
                                // })
                            ]
                        ),
                ]
            )
            ->actions(
                [
                    EditAction::make(),
                    // Tables\Actions\DeleteAction::make(),
                    DetachAction::make(),
                ]
            )
            ->bulkActions(
                [
                    DeleteBulkAction::make(),
                ]
            );
    }
}
