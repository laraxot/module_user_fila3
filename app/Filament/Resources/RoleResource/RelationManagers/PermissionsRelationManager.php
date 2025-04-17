<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;









class PermissionsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'permissions';

    /**
     * Configura lo schema del form per la gestione dei permessi.
     */
    public function getFormSchema(): array
{
    
        
    return [
              
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)

                ->placeholder(__('Inserisci il nome del permesso')),
        
      ];
}

    /**
     * Configura la tabella per la visualizzazione e la gestione dei permessi.
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')

                    ->sortable()
                    ->searchable(),
            ])
            ->filters([]) // Aggiungi eventuali filtri qui se necessario
            ->headerActions([
                Tables\Actions\CreateAction::make()

                    ->tooltip(__('Crea un nuovo permesso')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()

                    ->tooltip(__('Modifica permesso')),
                Tables\Actions\DeleteAction::make()

                    ->tooltip(__('Elimina permesso')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()

                    ->tooltip(__('Elimina i permessi selezionati')),
            ]);
    }
}
