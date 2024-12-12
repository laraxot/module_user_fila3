<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Widgets\Widget;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\NewPasswordSet;
use Modules\User\Http\Response\PasswordResetResponse;
use Modules\User\Rules\CheckOtpExpiredRule;
use Modules\Xot\Filament\Traits\TransTrait;
use Webmozart\Assert\Assert;

/**
 * @property ComponentContainer $form
 */
class PasswordExpiredWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    // use InteractsWithFormActions;
    use TransTrait;

    public ?string $current_password = '';

    public ?string $password = '';

    public ?string $passwordConfirmation = '';

    public array $data = [];

    /**
     * @var view-string
     */
    protected static string $view = 'user::filament.widgets.password-expired';

    protected static bool $shouldRegisterNavigation = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->columns(1)
            ->statePath('data');
    }

    public function getFormSchema(): array
    {
        return [
            $this->getCurrentPasswordFormComponent(),
            ...PasswordData::make()->getPasswordFormComponents('password'),
            /*
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
            */
        ];
    }

    public function getResetPasswordFormAction(): Action
    {
        return Action::make('resetPassword')
            ->submit('resetPassword');
    }

    public function hasLogo(): bool
    {
        return false;
    }

    public function resetPassword(): ?PasswordResetResponse
    {
        $data = $this->form->getState();
        Assert::string($current_password = Arr::get($data, 'current_password'));
        Assert::string($password = Arr::get($data, 'password'));
        $user = auth()->user();
        if (null === $user) {
            return null;
        }

        // check if current password is correct
        if (! Hash::check($current_password, $user->password)) {
            Notification::make()
                ->title(__('user::otp.notifications.wrong_password.title'))
                ->body(__('user::otp.notifications.wrong_password.body'))
                ->danger()
                ->send();

            return null;
        }

        // check if new password is different from the current password
        if (Hash::check($password, $user->password)) {
            Notification::make()
                ->title(__('user::otp.notifications.same_password.title'))
                ->body(__('user::otp.notifications.same_password.body'))
                ->danger()
                ->send();

            return null;
        }

        // check if both required columns exist in the database
        if (! Schema::hasColumn('users', 'password_expires_at')) {
            Notification::make()
                ->title(__('user::otp.notifications.column_not_found.title'))
                ->body(__('user::otp.notifications.column_not_found.body', [
                    'column_name' => 'password_expires_at',
                    'password_column_name' => 'password',
                    'table_name' => 'users',
                ]))
                ->danger()
                ->send();

            return null;
        }

        $pwd_data = PasswordData::make();
        // get OTP expiration minutes from PasswordData
        $otpExpirationMinutes = $pwd_data->otp_expiration_minutes;

        // Check if OTP is expired using updated_at
        if ($user->updated_at && now()->greaterThan($user->updated_at->addMinutes($otpExpirationMinutes))) {
            Notification::make()
                ->title(__('user::otp.notifications.otp_expired.title'))
                ->body(__('user::otp.notifications.otp_expired.body'))
                ->danger()
                ->send();

            return null;
        }

        // get password expiry date and time
        $passwordExpiryDateTime = now()->addDays($pwd_data->expires_in);

        // set password expiry date and time
        $user = tap($user)->update([
            'password_expires_at' => $passwordExpiryDateTime,
            'is_otp' => false,
            'password' => Hash::make($password),
        ]);

        event(new NewPasswordSet($user));

        Notification::make()
            ->title(__('user::otp.notifications.password_reset.success'))
            ->success()
            ->send();

        return new PasswordResetResponse();
    }

    protected function getCurrentPasswordFormComponent(): Component
    {
        return TextInput::make('current_password')
            // ->label(__('user::otp.form.current_password.label'))
            ->password()
            // ->revealable(filament()->arePasswordsRevealable())
            ->revealable()
            ->required()
            // ->rule(PasswordRule::default())
            ->rule(new CheckOtpExpiredRule())
            ->validationAttribute(static::trans('fields.current_password.validation_attribute'));
    }

    /*
    protected function getPasswordFormComponent(): Component
    {
        $validation_messages = __('user::validation');

        return TextInput::make('password')
            ->password()
            // ->revealable(filament()->arePasswordsRevealable())
            ->revealable()
            ->required()
            ->rule(PasswordRule::default())
            ->same('passwordConfirmation')
            ->validationMessages($validation_messages)
            ->validationAttribute(static::trans('fields.password.validation_attribute'));
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->password()
            // ->revealable(filament()->arePasswordsRevealable())
            ->revealable()
            ->required()
            ->dehydrated(false);
    }
    */

    /**
     * @return array<Action|ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getResetPasswordFormAction(),
        ];
    }
}
