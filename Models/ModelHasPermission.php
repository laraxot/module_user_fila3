<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\User\Database\Factories\ModelHasPermissionFactory;

/**
 * Modules\User\Models\ModelHasPermission.
 *
 * @property int $id
 * @property int $permission_id
 * @property string $model_type
 * @property string $model_id
<<<<<<< HEAD
<<<<<<< HEAD
 *
 * @method static ModelHasPermissionFactory factory($count = null, $state = [])
=======
=======
 *
>>>>>>> 74bdb69 (Check & fix styling)
 * @method static ModelHasPermissionFactory  factory($count = null, $state = [])
>>>>>>> 88cab95 (up)
 * @method static Builder|ModelHasPermission newModelQuery()
 * @method static Builder|ModelHasPermission newQuery()
 * @method static Builder|ModelHasPermission query()
 * @method static Builder|ModelHasPermission whereId($value)
 * @method static Builder|ModelHasPermission whereModelId($value)
 * @method static Builder|ModelHasPermission whereModelType($value)
 * @method static Builder|ModelHasPermission wherePermissionId($value)
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 *
 * @method static Builder|ModelHasPermission whereCreatedAt($value)
 * @method static Builder|ModelHasPermission whereCreatedBy($value)
 * @method static Builder|ModelHasPermission whereUpdatedAt($value)
 * @method static Builder|ModelHasPermission whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class ModelHasPermission extends BaseMorphPivot
{
    /**
     * @var array<string>
     *
     * @psalm-var list{'permission_id', 'model_type', 'model_id'}
     */
    protected $fillable = ['permission_id', 'model_type', 'model_id'];
}
