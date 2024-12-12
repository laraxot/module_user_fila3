<?php

declare(strict_types=1);

/**
 * inspired by  DutchCodingCompany\FilamentSocialite.
 */

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Xot\Datas\XotData;

/**
 * Modules\User\Models\SocialiteUser.
 *
 * @property int                                      $id
 * @property string                                   $user_id
 * @property string                                   $provider
 * @property string                                   $provider_id
 * @property string|null                              $token
 * @property string|null                              $name
 * @property string|null                              $email
 * @property string|null                              $avatar
 * @property \Illuminate\Support\Carbon|null          $created_at
 * @property \Illuminate\Support\Carbon|null          $updated_at
 * @property string|null                              $updated_by
 * @property string|null                              $created_by
 * @property \Modules\Xot\Contracts\UserContract|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereUserId($value)
 * @property string $uuid (DC2Type:guid)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereUuid($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
class SocialiteUser extends BaseModel
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        // 'id',
        'user_id',
        'provider',
        'provider_id',
        'token',
        'name',
        'email',
        'avatar',
    ];

    public function user(): BelongsTo
    {
        /** @var class-string<Model> */
        $user_class = XotData::make()->getUserClass();

        return $this->belongsTo($user_class);
    }
}
