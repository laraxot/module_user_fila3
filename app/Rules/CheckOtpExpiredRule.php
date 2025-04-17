<?php

declare(strict_types=1);

namespace Modules\User\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Modules\User\Datas\PasswordData;

/**
 * Regola di validazione per verificare se un codice OTP è scaduto.
 */
class CheckOtpExpiredRule implements ValidationRule
{
    /**
     * Determina se la regola di validazione si applica.
     *
     * @param string $attribute L'attributo che viene validato
     * @param string|int $value Il valore dell'attributo
     * @param \Closure(string): void $fail La closure da chiamare in caso di fallimento
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $user = Auth::user();
        if ($user === null) {
            $fail('utente non loggato');

            return;
        }
        if ($user->updated_at === null) {
            return;
        }

        // Get OTP expiration minutes from PasswordData
        $pwd_data = PasswordData::make();
        $otpExpirationMinutes = $pwd_data->otp_expiration_minutes;
        $otp_expires_at = $user->updated_at->addMinutes($otpExpirationMinutes);

        // Check if OTP is expired using updated_at
        if (now()->greaterThan($otp_expires_at)) {
            $fail($this->message());
        }
    }

    /**
     * Ottiene il messaggio di errore da visualizzare.
     *
     * @return string Il messaggio di errore
     */
    public function message(): string
    {
        return __('user::otp.notifications.otp_expired.body');
    }
}
