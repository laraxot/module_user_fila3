<?php

/**
 * Classe per la gestione delle configurazioni delle password.
 */

declare(strict_types=1);

namespace Modules\User\Datas;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Password;
use Modules\Tenant\Services\TenantService;
use Spatie\LaravelData\Data;

/**
 * Classe per la gestione dei dati relativi alle password.
 */
class PasswordData extends Data
{
    public int $otp_expiration_minutes = 60; // Durata in minuti della validità della password temporanea

    public int $otp_length = 6;  // Lunghezza del codice OTP

    public int $expires_in = 30; // The number of days before the password expires.

    public int $min = 6; // The minimum size of the password.

    public bool $mixedCase = false; // If the password requires at least one uppercase and one lowercase letter.

    public bool $letters = false; // If the password requires at least one letter.

    public bool $numbers = false; // If the password requires at least one number.

    public bool $symbols = false; // If the password requires at least one symbol.

    public bool $uncompromised = false; // If the password should not have been compromised in data leaks.

    public int $compromisedThreshold = 0; // The number of times a password can appear in data leaks before being considered compromised.

    public ?string $failMessage = null;

    private static ?self $instance = null;

    private string $field_name = 'new_password';

    /**
     * Crea un'istanza della classe PasswordData.
     *
     * @return self
     */
    public static function make(): self
    {
        if (! self::$instance) {
            /** @var array<string, mixed> $data */
            $data = TenantService::getConfig('password');
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    /**
     * Restituisce la regola di validazione per la password.
     *
     * @return Password
     */
    public function getPasswordRule(): Password
    {
        $pwd = Password::min($this->min);
        if ($this->mixedCase) {
            $pwd = $pwd->mixedCase();
        }
        if ($this->letters) {
            $pwd = $pwd->letters();
        }
        if ($this->numbers) {
            $pwd = $pwd->numbers();
        }
        if ($this->symbols) {
            $pwd = $pwd->symbols();
        }
        if ($this->uncompromised) {
            $pwd = $pwd->uncompromised($this->compromisedThreshold);
        }

        // $pwd = $pwd->message(__('user::validation'));
        // Cannot access protected property Illuminate\Validation\Rules\Password::$messages
        // $pwd->messages = array_merge($pwd->messages, __('user::validation'));
        // $pwd->fail(__('user::validation'));
        return $pwd;
    }

    /**
     * Converte l'oggetto in un array.
     *
     * @return array<string, int|bool|string|null>
     */
    public function toArray(): array
    {
        return [
            'otp_expiration_minutes' => $this->otp_expiration_minutes,
            'otp_length' => $this->otp_length,
            'expires_in' => $this->expires_in,
            'min' => $this->min,
            'mixedCase' => $this->mixedCase,
            'letters' => $this->letters,
            'numbers' => $this->numbers,
            'symbols' => $this->symbols,
            'uncompromised' => $this->uncompromised,
            'compromisedThreshold' => $this->compromisedThreshold,
            'failMessage' => $this->failMessage,
        ];
    }

    /**
     * Restituisce il testo di aiuto per la password.
     *
     * @return string
     */
    public function getHelperText(): string
    {
        $msg = 'La password deve essere composta da minimo '.$this->min.' caratteri';
        $msg .= ', almeno una lettera maiuscola';
        $msg .= ', una minuscola';
        $msg .= ', un numero';
        $msg .= ' e un carattere speciale.';

        return $msg;
    }

    /**
     * Restituisce i messaggi di validazione.
     *
     * @return array<string, string>
     */
    public function getValidationMessages(): array
    {
        /** @var array<string, string> $messages */
        $messages = __('user::validation');

        return $messages;
    }

    /**
     * Restituisce il componente del form per la password.
     *
     * @param string $field_name Nome del campo
     * @return Component
     */
    public function getPasswordFormComponent(string $field_name = 'new_password'): Component
    {
        $this->field_name = $field_name;
        $field = TextInput::make($field_name)
            ->password()

            // ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()" tabindex="3"> {{ __(\'filament-panels::pages/auth/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->placeholder(__('user::fields.new_password.placeholder'))
            // ->revealable(filament()->arePasswordsRevealable())
            ->revealable(true)
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2])
            ->rule(Password::default())
            ->validationMessages($this->getValidationMessages())
            ->helperText($this->getHelperText());
        // ->live()

        return $field;
    }

    /**
     * Restituisce il componente del form per la conferma della password.
     *
     * @return Component
     */
    public function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')

            ->password()
            // ->revealable(filament()->arePasswordsRevealable())
            ->revealable(true)
            ->required()
            // ->visible(fn (Get $get): bool => filled($get($this->field_name)))
            // ->dehydrated(false)
            ->same($this->field_name)
            ->validationMessages($this->getValidationMessages());
    }

    /**
     * Restituisce i componenti del form per la password.
     *
     * @param string $field_name Nome del campo
     * @return array<Component>
     */
    public function getPasswordFormComponents(string $field_name = 'new_password'): array
    {
        return [
            $this->getPasswordFormComponent($field_name),
            $this->getPasswordConfirmationFormComponent(),
        ];
    }
}
