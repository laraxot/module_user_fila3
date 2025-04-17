<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Modules\User\Models\AuthenticationLog;

/**
 * Trait HasAuthenticationLogTrait.
 *
 * This trait provides functionality for logging authentication events for any model that uses it.
 * It includes methods for retrieving the latest authentication logs, login timestamps, IP addresses,
 * and other related information, including tracking consecutive login days.
 *
 * property MorphMany<AuthenticationLog, static> $authentications      The authentication logs related to the model.
 * property MorphOne<AuthenticationLog, static>  $latestAuthentication The most recent authentication log entry.
 */
trait HasAuthenticationLogTrait
{
    /**
     * Get all of the model's authentication logs.
     *
     * @return MorphMany<AuthenticationLog, static>
     */
    public function authentications(): MorphMany
    {
        // @phpstan-ignore return.type
        return $this->morphMany(AuthenticationLog::class, 'authenticatable')
            ->latest('login_at');
    }

    /**
     * Get the latest authentication attempt for the model.
     *
     * @return MorphOne<AuthenticationLog, static>
     */
    public function latestAuthentication(): MorphOne
    {
        return $this->morphOne(AuthenticationLog::class, 'authenticatable')
            ->latestOfMany('login_at');
    }

    /**
     * Specify how to notify about authentication logs.
     *
     * @return list<string> a list of notification channels
     */
    public function notifyAuthenticationLogVia(): array
    {
        return ['mail'];
    }

    /**
     * Get the timestamp of the most recent login attempt.
     *
     * @return ?Carbon the timestamp of the last login or null if none exists
     */
    public function lastLoginAt(): ?Carbon
    {
        return $this->authentications()->first()?->login_at;
    }

    /**
     * Get the timestamp of the most recent successful login attempt.
     *
     * @return ?Carbon the timestamp of the last successful login or null if none exists
     */
    public function lastSuccessfulLoginAt(): ?Carbon
    {
        return $this->authentications()->where('login_successful', true)->first()?->login_at;
    }

    /**
     * Get the IP address of the most recent login attempt.
     *
     * @return ?string the IP address of the last login or null if none exists
     */
    public function lastLoginIp(): ?string
    {
        return $this->authentications()->first()?->ip_address;
    }

    /**
     * Get the IP address of the most recent successful login attempt.
     *
     * @return ?string the IP address of the last successful login or null if none exists
     */
    public function lastSuccessfulLoginIp(): ?string
    {
        return $this->authentications()->where('login_successful', true)->first()?->ip_address;
    }

    /**
     * Get the timestamp of the second most recent login attempt (previous login).
     *
     * @return ?Carbon the timestamp of the previous login or null if less than two logins exist
     */
    public function previousLoginAt(): ?Carbon
    {
        return $this->authentications()->skip(1)->first()?->login_at;
    }

    /**
     * Get the IP address of the second most recent login attempt (previous login).
     *
     * @return ?string the IP address of the previous login or null if less than two logins exist
     */
    public function previousLoginIp(): ?string
    {
        return $this->authentications()->skip(1)->first()?->ip_address;
    }

    /**
     * Calculate the number of consecutive days the user has logged in.
     *
     * @return int the number of consecutive days the user has logged in
     */
    public function consecutiveDaysLogin(): int
    {
        return once(function (): int {
            $date = Carbon::now();
            $days = 0;

            // Count the logins for the current day.
            $count = $this->authentications()->whereDate('login_at', $date)->count();

            while ($count > 0) {
                $date = $date->subDay();
                $count = $this->authentications()->whereDate('login_at', $date)->count();
                $days++;
            }

            return $days;
        });
    }
}
