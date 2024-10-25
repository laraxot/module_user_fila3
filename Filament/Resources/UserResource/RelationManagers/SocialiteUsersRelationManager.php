<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\User\Models\SocialiteUser;

class SocialiteUsersRelationManager extends RelationManager
{
    protected static string $relationship = 'socialiteUsers';

    /**
     * Configure the form schema for managing Socialite User data.
     */
    public function form(Form $form): Form
    {
        return $form->schema($this->getFormSchema());
    }

    /**
     * Define form fields in a dedicated method for reusability.
     *
     * @return array<Forms\Components\Component>
     */
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('provider')
                ->label(__('Provider'))
                ->required()
                ->maxLength(255)
                ->placeholder(__('Enter provider name, e.g., Google, Facebook')),

            Forms\Components\TextInput::make('provider_id')
                ->label(__('Provider ID'))
                ->required()
                ->maxLength(255)
                ->placeholder(__('Enter the provider ID for the user')),

            Forms\Components\TextInput::make('name')
                ->label(__('Name'))
                ->maxLength(255)
                ->placeholder(__('User’s name associated with the provider')),

            Forms\Components\TextInput::make('email')
                ->label(__('Email'))
                ->email()
                ->maxLength(255)
                ->placeholder(__('User’s email associated with the provider')),

            Forms\Components\TextInput::make('avatar')
                ->label(__('Avatar URL'))
                ->url()
                ->maxLength(512)
                ->placeholder(__('URL of the user’s avatar image')),
        ];
    }

    /**
     * Configure the table for displaying Socialite User data.
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('provider')
            ->columns($this->getTableColumns())
            ->filters($this->getTableFilters())
            ->headerActions($this->getHeaderActions())
            ->actions($this->getTableActions())
            ->bulkActions($this->getBulkActions());
    }

    /**
     * Define table columns in a separate, strongly-typed method.
     *
     * @return array<Column>
     */
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('provider')
                ->label(__('Provider'))
                ->searchable(),

            Tables\Columns\TextColumn::make('provider_id')
                ->label(__('Provider ID'))
                ->searchable(),

            Tables\Columns\TextColumn::make('name')
                ->label(__('Name'))
                ->searchable(),

            Tables\Columns\TextColumn::make('email')
                ->label(__('Email'))
                ->searchable(),

            Tables\Columns\ImageColumn::make('avatar')
                ->label(__('Avatar'))
                ->size(40),
        ];
    }

    /**
     * Define table filters in a dedicated method.
     *
     * @return array<Filter>
     */
    protected function getTableFilters(): array
    {
        return [
            // Tables\Filters\TrashedFilter::make(), // Optional: filter for trashed records if using soft deletes
        ];
    }

    /**
     * Define header actions in a dedicated method.
     *
     * @return array<Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Tables\Actions\AttachAction::make()->label(__('Attach Socialite User')),
        ];
    }

    /**
     * Define row-level table actions in a separate method.
     *
     * @return array<Action>
     */
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\DetachAction::make(),
            Tables\Actions\ViewAction::make(),
        ];
    }

    /**
     * Define bulk actions in a dedicated method.
     *
     * @return array<Action>
     */
    protected function getBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DetachBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make()->label(__('Delete Selected')),
            ]),
        ];
    }

    /**
     * Query scope to apply conditions to the relation manager.
     */
    protected function applyTableQueryScope(Builder $query): Builder
    {
        return $query->when(
            in_array(SoftDeletingScope::class, class_uses_recursive(SocialiteUser::class)),
            fn (Builder $query) => $query->withTrashed()
        );
    }
}
