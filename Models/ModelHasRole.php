<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\ModelHasRoleFactory;

/**
 * Modules\User\Models\ModelHasRole.
 *
 * @mixin IdeHelperModelHasRole
 *
 * @property string $role_id
 * @property string $model_type
 * @property string $model_id
 *
 * @method static ModelHasRoleFactory  factory($count = null, $state = [])
 * @method static Builder|ModelHasRole newModelQuery()
 * @method static Builder|ModelHasRole newQuery()
 * @method static Builder|ModelHasRole query()
 * @method static Builder|ModelHasRole whereModelId($value)
 * @method static Builder|ModelHasRole whereModelType($value)
 * @method static Builder|ModelHasRole whereRoleId($value)
 *
 * @mixin \Eloquent
 */
class ModelHasRole extends BaseMorphPivot
{
    use HasUuids;
    // use Traits\UuidTrait;
    /**
     * @var array<string>
     */
    protected $fillable = ['id', 'role_id', 'model_type', 'model_id', 'team_id'];

    protected $connection = 'user';

    protected $casts = [
        'id' => 'string',
    ];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * Create a new pivot model from raw values returned from a query.
     *
     * @param array  $attributes
     * @param string $table
     * @param bool   $exists
     *
     * @throws \Exception
     *
     * @return static
     */
    public static function fromRawAttributes(Model $parent, $attributes, $table, $exists = false)
    {
        // https://laracasts.com/discuss/channels/eloquent/generating-custom-id-uuid-for-many-to-many-relationship-pivot-table
        // https://www.appsloveworld.com/php/394/laravel-eloquent-uuid-in-a-pivot-table
        dddx('a');
        if (! $exists && ! \array_key_exists('id', $attributes)) {
            $attributes['id'] = Str::uuid(); // Uuid::generate()->string;
        }

        return parent::fromRawAttributes($parent, $attributes, $table, $exists);
    }
}
