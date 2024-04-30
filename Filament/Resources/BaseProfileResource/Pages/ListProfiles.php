<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\BaseProfileResource\Pages;

use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;
use Modules\Xot\Datas\XotData;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Collection;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Modules\User\Filament\Resources\BaseProfileResource;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Modules\User\Filament\Actions\Profile\ChangeProfilePasswordAction;

class ListProfiles extends ListRecords
{
    use NavigationLabelTrait;

    protected static string $resource = BaseProfileResource::class;

    public function getModelLabel(): string
    {
        return static::trans('navigation.name');
    }

    public function getPluralModelLabel(): string
    {
        return static::trans('navigation.plural');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            ChangeProfilePasswordAction::make(),
            Tables\Actions\EditAction::make()->label('')->tooltip(__('ui:txt.edit')),
            Tables\Actions\ViewAction::make()->label('')->tooltip(__('ui:txt.view')),
            Tables\Actions\DeleteAction::make()->label('')->tooltip(__('ui:txt.delete')),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'type' => TextColumn::make('type')
                ->label(static::trans('fields.type'))
                ->sortable(),

            'user_name' => TextColumn::make('user.name')
                ->label(static::trans('fields.user_name'))
                ->sortable()
                ->searchable()
                ->default(
                    function ($record) {
                        $user = $record->user;
                        $user_class = XotData::make()->getUserClass();
                        if (null == $user) {
                            $user = $user_class::firstWhere(['email' => $record->email]);
                        }
                        if (null == $user) {
                            $data = $record->toArray();
                            $user_data = Arr::except($data, ['id']);
                            $user = $user_class::create($user_data);
                        }
                        $record->update(['user_id' => $user->id]);

                        return $user->name;
                    }
                ),
            'first_name' => TextColumn::make('first_name')
                ->label(static::trans('fields.first_name'))
                ->sortable()
                ->searchable(),
            'last_name' => TextColumn::make('last_name')
                ->label(static::trans('fields.last_name'))
                ->sortable()
                ->searchable(),
            'email' => TextColumn::make('email')
                ->label(static::trans('fields.email'))
                ->sortable()
                ->searchable(),
            'is_active' => IconColumn::make('is_active')
                ->label(static::trans('fields.is_active'))
                ->boolean(),
            'photo' => SpatieMediaLibraryImageColumn::make('photo')
                ->collection('profile'),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            // Tables\Actions\BulkActionGroup::make([
            //    Tables\Actions\DeleteBulkAction::make(),
            /*
                Tables\Actions\BulkAction::make('refresh-profiles')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        $users = User::all();

                        foreach ($users as $user) {
                            Profile::firstOrCreate(
                                ['user_id' => $user->id, 'email' => $user->email],
                                ['credits' => 1000]
                            );
                        }
                    }),
                */
            // ]),
            Tables\Actions\DeleteBulkAction::make(),
            BulkAction::make('bulk_activate')

                        ->label(static::trans('actions.bulk_activate.cta'))
                        ->action(
                            function (Collection $collection) {
                                $collection
                                    ->chunk(20)
                                    ->each
                                    ->each(
                                        function ($user): void {
                                            Assert::isInstanceOf($user, Model::class);
                                            $user->update(['is_active' => true]);
                                        }
                                    );
                            }
                        ),

            BulkAction::make('bulk_inactivate')

                ->label(static::trans('actions.bulk_inactivate.cta'))
                ->action(
                    function (Collection $collection) {
                        $collection
                            ->chunk(20)
                            ->each
                            ->each(
                                function ($user): void {
                                    Assert::isInstanceOf($user, Model::class);
                                    $user->update(['is_active' => true]);
                                }
                            );
                    }
                ),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            TernaryFilter::make('is_active')
            ->placeholder(static::trans('filters.is_active.all'))
            ->trueLabel(static::trans('filters.is_active.active'))
            ->falseLabel(static::trans('filters.is_active.inactive'))
            ->queries(
                true: static fn (Builder $query) => $query->where('is_active', '=', true),
                false: static fn (Builder $query) => $query->where('is_active', '=', false),
            )
            ->label(static::trans('fields.is_active')),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            // ->query($this->getTableQuery())
            ->actions($this->getTableActions())
            // ->actionsColumnLabel($this->getTableActionsColumnLabel())
            // ->checkIfRecordIsSelectableUsing($this->isTableRecordSelectable())
            ->columns($this->getTableColumns())
            // ->columnToggleFormColumns($this->getTableColumnToggleFormColumns())
            // ->columnToggleFormMaxHeight($this->getTableColumnToggleFormMaxHeight())
            // ->columnToggleFormWidth($this->getTableColumnToggleFormWidth())
            // ->content($this->getTableContent())
            // ->contentFooter($this->getTableContentFooter())
            // ->contentGrid($this->getTableContentGrid())
            // ->defaultSort($this->getDefaultTableSortColumn(), $this->getDefaultTableSortDirection())
            // ->deferLoading($this->isTableLoadingDeferred())
            // ->description($this->getTableDescription())
            // ->deselectAllRecordsWhenFiltered($this->shouldDeselectAllRecordsWhenTableFiltered())
            // ->emptyState($this->getTableEmptyState())
            // ->emptyStateActions($this->getTableEmptyStateActions())
            // ->emptyStateDescription($this->getTableEmptyStateDescription())
            // ->emptyStateHeading($this->getTableEmptyStateHeading())
            // ->emptyStateIcon($this->getTableEmptyStateIcon())
            ->filters($this->getTableFilters())
            // ->filtersFormMaxHeight($this->getTableFiltersFormMaxHeight())
            // ->filtersFormWidth($this->getTableFiltersFormWidth())
            // ->groupedBulkActions($this->getTableBulkActions())
            ->bulkActions($this->getTableBulkActions());
        // ->header($this->getTableHeader())
        // ->headerActions($this->getTableHeaderActions())
        // ->modelLabel($this->getTableModelLabel())
        // ->paginated($this->isTablePaginationEnabled())
        // ->paginatedWhileReordering($this->isTablePaginationEnabledWhileReordering())
        // ->paginationPageOptions($this->getTableRecordsPerPageSelectOptions())
        // ->persistFiltersInSession($this->shouldPersistTableFiltersInSession())
        // ->persistSearchInSession($this->shouldPersistTableSearchInSession())
        // ->persistColumnSearchesInSession($this->shouldPersistTableColumnSearchInSession())
        // ->persistSortInSession($this->shouldPersistTableSortInSession())
        // ->pluralModelLabel($this->getTablePluralModelLabel())
        // ->poll($this->getTablePollingInterval())
        // ->recordAction($this->getTableRecordActionUsing())
        // ->recordClasses($this->getTableRecordClassesUsing())
        // ->recordTitle(fn (Model $record): ?string => $this->getTableRecordTitle($record))
        // ->recordUrl($this->getTableRecordUrlUsing())
        // ->reorderable($this->getTableReorderColumn())
        // ->selectCurrentPageOnly($this->shouldSelectCurrentPageOnly())
        // ->striped($this->isTableStriped())
    }
}