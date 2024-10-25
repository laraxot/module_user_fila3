<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Manages the relationship between users and tenants.
 *
 * This class provides the form schema and table configuration for the "tenants" relationship
 * with strong typing and enhanced structure for stability and professionalism.
 */
final class TenantsRelationManager extends RelationManager
{
    protected static string $relationship = 'tenants';

    /**
     * Set up the form schema for tenant relations.
     *
     * @param Form $form the form instance for configuration
     *
     * @return Form configured form instance
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('user::fields.name'))
                    ->required()
                    ->maxLength(255),
            ]);
    }

    /**
     * Set up the table schema and functionality for tenants.
     *
     * @param Table $table the table instance for configuration
     *
     * @return Table configured table instance
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns($this->getTableColumns())
            ->filters($this->getTableFilters())
            ->headerActions($this->getTableHeaderActions())
            ->actions($this->getTableActions())
            ->bulkActions($this->getTableBulkActions())
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('60s');
    }

    /**
     * Define table columns for displaying tenant information.
     *
     * @return array<int, TextColumn> configured table columns
     */
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label(__('user::fields.name'))
                ->sortable()
                ->searchable(),
            TextColumn::make('created_at')
                ->label(__('user::fields.created_at'))
                ->dateTime()
                ->sortable(),
            TextColumn::make('updated_at')
                ->label(__('user::fields.updated_at'))
                ->dateTime()
                ->sortable(),
        ];
    }

    /**
     * Define filters for the table.
     *
     * @return array<int, Filter> configured table filters
     */
    protected function getTableFilters(): array
    {
        return [
            Filter::make('active')
                ->label(__('user::filters.active_tenants'))
                ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                ->toggle(),
        ];
    }

    /**
     * Define header actions for the table.
     *
     * @return array<int, Action> configured header actions
     */
    protected function getTableHeaderActions(): array
    {
        return [
            AttachAction::make()
                ->label('')
                ->tooltip(__('user::actions.attach_tenant'))
                ->icon('heroicon-o-link'),
        ];
    }

    /**
     * Define row actions for each tenant record.
     *
     * @return array<int, Action> configured row actions
     */
    protected function getTableActions(): array
    {
        return [
            EditAction::make()
                ->label('')
                ->tooltip(__('user::actions.edit'))
                ->icon('heroicon-o-pencil')
                ->color('warning'),

            Tables\Actions\DeleteAction::make()
                ->label('')
                ->tooltip(__('user::actions.delete'))
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation(),

            DetachAction::make()
                ->label('')
                ->tooltip(__('user::actions.detach_tenant'))
                ->icon('heroicon-o-x-circle')
                ->color('secondary')
                ->requiresConfirmation(),
        ];
    }

    /**
     * Define bulk actions for the table.
     *
     * @return array<int, BulkAction> configured bulk actions
     */
    protected function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make()
                ->label('')
                ->tooltip(__('user::actions.delete_selected'))
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation(),
        ];
    }
}
