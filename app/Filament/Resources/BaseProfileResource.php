<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Filament\Resources\BaseProfileResource\Pages;
use Modules\User\Models\BaseProfile;
use Modules\Xot\Filament\Resources\XotBaseResource;




use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;





abstract class BaseProfileResource extends XotBaseResource
{
    use Translatable;

    protected static ?string $model = BaseProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getFormSchema(): array
    {
        return [
            // Forms\Components\TextInput::make('user_id'),
            // Forms\Components\TextInput::make('user_id')->readonly(),
            Forms\Components\TextInput::make('user.name'),
            Forms\Components\TextInput::make('email'),
            Forms\Components\TextInput::make('first_name'),
            Forms\Components\TextInput::make('last_name'),
            SpatieMediaLibraryFileUpload::make('photo_profile')
                // ->image()
                // ->maxSize(5000)
                // ->multiple()
                // ->enableReordering()
                ->openable()
                ->downloadable()
                ->columnSpanFull()
                // ->collection('avatars')
                // ->conversion('thumbnail')
                ->disk('uploads')
                ->directory('photos')
                ->collection('photo_profile'),
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
            'index' => Pages\ListProfiles::route('/'),
            // 'create' => Pages\CreateProfile::route('/create'),
            // 'edit' => Pages\EditProfile::route('/{record}/edit'),
            // 'getcredits' => Pages\GetCreditProfile::route('/{record}/getcredits'),
        ];
    }
}
