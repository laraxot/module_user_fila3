<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\User\Filament\Resources\SocialProviderResource\Pages;
use Modules\User\Models\SocialProvider;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * @property SocialProvider $record
 *                                  -------
 */
class SocialProviderResource extends XotBaseResource
{
    protected static ?string $model = SocialProvider::class;

    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->placeholder(static::trans('fields.name.placeholder'))
                ->helperText(static::trans('fields.name.helper_text')),

            'scopes' => KeyValue::make('scopes')
                // ->placeholder(static::trans('fields.scopes.placeholder'))
                ->helperText(static::trans('fields.scopes.helper_text')),

            'client_id' => TextInput::make('client_id')
                ->required()
                ->maxLength(255)
                ->placeholder(static::trans('fields.client_id.placeholder'))
                ->helperText(static::trans('fields.client_id.helper_text')),

            'client_secret' => TextInput::make('client_secret')
                ->required()
                ->maxLength(1024)
                ->placeholder(static::trans('fields.client_secret.placeholder'))
                ->helperText(static::trans('fields.client_secret.helper_text')),

            'redirect' => TextInput::make('redirect')
                ->required()
                ->maxLength(255)
                ->placeholder(static::trans('fields.redirect.placeholder'))
                ->helperText(static::trans('fields.redirect.helper_text')),

            'additional_params' => Textarea::make('additional_params'),

            'enabled' => Toggle::make('enabled'),
        ];
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialProviders::route('/'),
            'create' => Pages\CreateSocialProvider::route('/create'),
            'view' => Pages\ViewSocialProvider::route('/{record}'),
            'edit' => Pages\EditSocialProvider::route('/{record}/edit'),
        ];
    }
}
