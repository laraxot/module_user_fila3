<?php

declare(strict_types=1);

/**
 * @see https://github.com/rappasoft/laravel-authentication-log/blob/main/src/Models/AuthenticationLog.php
 */

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * 
 *
 * @property int $id
 * @property string $authenticatable_type
 * @property int $authenticatable_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon|null $login_at
 * @property bool $login_successful
 * @property \Illuminate\Support\Carbon|null $logout_at
 * @property bool $cleared_by_user
 * @property array|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Database\Eloquent\Model|\Eloquent $authenticatable
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\User\Database\Factories\AuthenticationLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereAuthenticatableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereAuthenticatableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereClearedByUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereLoginSuccessful($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereLogoutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereUserAgent($value)
 * @mixin \Eloquent
 */
class AuthenticationLog extends BaseModel
{
    // public $timestamps = false;

    // protected $table = 'authentication_log';

    protected $fillable = [
        'ip_address',
        'user_agent',
        'login_at',
        'login_successful',
        'logout_at',
        'cleared_by_user',
        'location',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'cleared_by_user' => 'boolean',
            'location' => 'array',
            'login_successful' => 'boolean',
            'login_at' => 'datetime',
            'logout_at' => 'datetime',
        ];
    }

    // public function __construct(array $attributes = [])
    // {
    // if (! isset($this->connection)) {
    //    $this->setConnection(config('authentication-log.db_connection'));
    // }

    //    parent::__construct($attributes);
    // }

    // public function getTable()
    // {
    //    return config('authentication-log.table_name', parent::getTable());
    // }

    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }
}
