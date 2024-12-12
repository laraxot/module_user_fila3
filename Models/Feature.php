<?php

declare(strict_types=1);

namespace Modules\User\Models;

/**
 * 
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\User\Database\Factories\FeatureFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Feature   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature   query()
 * @property string                          $id
 * @property string                          $name
 * @property string                          $scope
 * @property string                          $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereValue($value)
 * @mixin \Eloquent
 */
class Feature extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'id',
        'name',
        'scope',
        'value',
    ];
}
