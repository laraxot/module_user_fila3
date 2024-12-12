<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Tenancy;

use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile as BaseEditTenantProfile;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

class EditTenantProfile extends BaseEditTenantProfile
{
    public static function getLabel(): string
    {
        return __('user::tenancy.navigation.edit');
    }

    public function form(Form $form): Form
    {
        $resource = XotData::make()->getTenantResourceClass();

        Assert::isInstanceOf($res = $resource::form($form), Form::class);

        return $res;
        /*
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()

                    ->translateLabel(),
                TextInput::make('phone')
                    ->required()
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')

                    ->translateLabel(),
                TextInput::make('email')
                    ->required()
                    ->email()

                    ->translateLabel(),
            ]);
        */
    }
}
