<?php

declare(strict_types=1);

/**
 * @see https://github.com/savannabits/filament-tenancy-starter/blob/main/app/Filament/resources/TenantResource.php
 */

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Modules\User\Filament\Resources\TenantResource\Pages\CreateTenant;
use Modules\User\Filament\Resources\TenantResource\Pages\EditTenant;
use Modules\User\Filament\Resources\TenantResource\Pages\ListTenants;
use Modules\User\Filament\Resources\TenantResource\Pages\ViewTenant;
use Modules\User\Filament\Resources\TenantResource\RelationManagers;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\XotBaseResource;




use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;





class TenantResource extends XotBaseResource
{
    // protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    /**
     * Get the model class name for this resource.
     *
     * @return class-string<\Illuminate\Database\Eloquent\Model>
     */
    public static function getModel(): string
    {
        $xot = XotData::make();

        /** @var class-string<\Illuminate\Database\Eloquent\Model> */
        return $xot->getTenantClass();
    }

    public static function getFormSchema(): array
    {
        return [
            'tenant_section' => Section::make()
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->unique(table: 'tenants', ignoreRecord: true)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (callable $set, $state) {
                            $set('slug', Str::slug($state));
                            $set('domain', Str::slug($state));
                        })
                        ->columnSpanFull()
                        ->placeholder(static::trans('fields.name.placeholder'))
                        ->helperText(static::trans('fields.name.helper_text')),

                    TextInput::make('slug')
                        ->required()
                        ->disabled(fn ($context) => $context !== 'create')
                        ->unique(table: 'tenants', ignoreRecord: true)
                        ->helperText(static::trans('fields.slug.helper_text')),

                    TextInput::make('domain')
                        ->required()
                        ->visible(fn ($context) => $context === 'create')
                        ->unique(table: 'domains', ignoreRecord: true)
                        ->prefix('https://')
                        ->suffix('.'.request()->getHost())
                        ->placeholder(static::trans('fields.domain.placeholder'))
                        ->helperText(static::trans('fields.domain.helper_text')),

                    TextInput::make('email_address')
                        ->email()
                        ->placeholder(static::trans('fields.email_address.placeholder'))
                        ->helperText(static::trans('fields.email_address.helper_text')),

                    TextInput::make('phone')
                        ->tel()
                        ->placeholder(static::trans('fields.phone.placeholder'))
                        ->helperText(static::trans('fields.phone.helper_text')),

                    TextInput::make('mobile')
                        ->tel()
                        ->placeholder(static::trans('fields.mobile.placeholder'))
                        ->helperText(static::trans('fields.mobile.helper_text')),

                    TextInput::make('address')
                        ->placeholder(static::trans('fields.address.placeholder'))
                        ->helperText(static::trans('fields.address.helper_text')),

                    ColorPicker::make('primary_color')
                        ->helperText(static::trans('fields.primary_color.helper_text')),

                    ColorPicker::make('secondary_color')
                        ->helperText(static::trans('fields.secondary_color.helper_text')),
                ])
                ->columns(2),
        ];
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers\DomainsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenants::route('/'),
            'create' => CreateTenant::route('/create'),
            'view' => ViewTenant::route('/{record}'),
            'edit' => EditTenant::route('/{record}/edit'),
        ];
    }
}
