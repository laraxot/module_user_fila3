<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Models\Traits\RelationX;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Webmozart\Assert\Assert;

/**
 * Class Permission.
 *
 * Extends Spatie's Permission model to interact with the permission system.
 *
 * @property string                                                                    $id
 * @property string                                                                    $name
 * @property string                                                                    $guard_name
 * @property Carbon|null                                                               $created_at
 * @property Carbon|null                                                               $updated_at
 * @property string|null                                                               $created_by
 * @property string|null                                                               $updated_by
 * @property Collection<int, Role>                                                     $roles
 * @property int|null                                                                  $roles_count
 * @property EloquentCollection<int, \Illuminate\Database\Eloquent\Model&UserContract> $users
 * @property int|null                                                                  $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 *
 * @property EloquentCollection<int, Permission> $permissions
 * @property int|null                            $permissions_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutRole($roles, $guard = null)
 *
 * @property PermissionRole|null $pivot
 *
 * @mixin \Eloquent
 */
class Permission extends SpatiePermission
{
    use RelationX;

    /** @var string */
    protected $connection = 'user';
    /** @var string */
    protected $keyType = 'string';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'name',
        'guard_name',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'name' => 'string',
            'guard_name' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getTable(): string
    {
        Assert::string($table = config('permission.table_names.permissions'));

        return $table;
    }

    /**
     * The roles associated with the permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToManyX(Role::class);
    }

    /**
     * The users associated with the permission.
     */
    public function users(): BelongsToMany
    {
        $userClass = XotData::make()->getUserClass();

        return $this->belongsToManyX($userClass);
    }
}
