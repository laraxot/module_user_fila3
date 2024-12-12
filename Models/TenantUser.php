<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Support\Carbon;

/**
 * Modules\User\Models\TenantUser.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser query()
 *
 * @property int         $id
 * @property string|null $tenant_id
 * @property string|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUuid($value)
 *
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereTenantId($value)
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @mixin \Eloquent
 */
class TenantUser extends BasePivot
{
    protected $connection = 'user';

    // public $incrementing = false;

    // protected $primaryKey = 'id';

    // protected $keyType = 'string';

    /** @var list<string> */
    protected $fillable = [
        'tenant_id',
        'user_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',

            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',

            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',

            // 'email_verified_at' => 'datetime',
            // 'password' => 'hashed', //Call to undefined cast [hashed] on column [password] in model [Modules\User\Models\User].
            // 'is_active' => 'boolean',
            // 'roles.pivot.id' => 'string',
            // https://github.com/beitsafe/laravel-uuid-auditing
            // ALTER TABLE model_has_role CHANGE COLUMN `id` `id` CHAR(37) NOT NULL DEFAULT uuid();
        ];
    }
}
