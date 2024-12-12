<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Support\Carbon;
use Modules\User\Database\Factories\PasswordResetFactory;

/**
 * Modules\User\Models\PasswordReset.
 *
 * @property int         $id
 * @property string      $email
 * @property string      $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $user_id
 * @property string|null $updated_by
 * @property string|null $created_by
 *
 * @method static PasswordResetFactory                                factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset query()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereUserId($value)
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @mixin \Eloquent
 */
class PasswordReset extends BaseModel
{
    /**
     * @var list<string>
     *
     * @psalm-var list{'email', 'token', 'created_at', 'updated_at', 'created_by', 'updated_by'}
     */
    protected $fillable = ['email', 'token', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_resets';
}// end class PasswordReset
