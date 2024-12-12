<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Support\Carbon;
use Modules\User\Database\Factories\ModelHasPermissionFactory;

/**
 * Modules\User\Models\ModelHasPermission.
 *
 * @property int    $id
 * @property int    $permission_id
 * @property string $model_type
 * @property string $model_id
 *
 * @method static ModelHasPermissionFactory                                factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission wherePermissionId($value)
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereUpdatedBy($value)
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property string|null                                 $team_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereTeamId($value)
 *
 * @mixin \Eloquent
 */
class ModelHasPermission extends BaseMorphPivot
{
    /**
     * @var list<string>
     *
     * @psalm-var list{'permission_id', 'model_type', 'model_id'}
     */
    protected $fillable = ['permission_id', 'model_type', 'model_id'];
}
