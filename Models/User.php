<?php

declare(strict_types=1);

namespace Modules\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Laravel\Sanctum\HasApiTokens;
use Filament\Panel;
use Laravel\Passport\Token;
use Laravel\Passport\Client;

use Illuminate\Support\Carbon;
use Modules\Xot\Datas\XotData;
use Illuminate\Support\Collection;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Modules\User\Models\Traits\HasTeams;
use Spatie\Permission\Models\Permission;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Builder;
use Filament\Models\Contracts\FilamentUser;
use Modules\User\Models\Traits\HasProfilePhoto;
use Modules\User\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\DatabaseNotification;
use Spatie\PersonalDataExport\ExportsPersonalData;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Traits\CanExportPersonalData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\User\Models\Traits\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Contracts\UserContract as UserJetContract;
use Illuminate\Notifications\DatabaseNotificationCollection;

/**
 * Modules\User\Models\User.
 *
 * @property int                                                       $id
 * @property string                                                    $name
 * @property string                                                    $email
 * @property string                                                    $api_token
 * @property Carbon|null                                               $email_verified_at
 * @property string                                                    $password
 * @property string|null                                               $two_factor_secret
 * @property string|null                                               $two_factor_recovery_codes
 * @property string|null                                               $two_factor_confirmed_at
 * @property string|null                                               $remember_token
 * @property int|null                                                  $current_team_id
 * @property string|null                                               $profile_photo_path
 * @property Carbon|null                                               $created_at
 * @property Carbon|null                                               $updated_at
 * @property \Illuminate\Database\Eloquent\Collection<int, Client>     $clients
 * @property int|null                                                  $clients_count
 * @property string                                                    $profile_photo_url
 * @property DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property int|null                                                  $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 * @property int|null                                                  $permissions_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Role>       $roles
 * @property int|null                                                  $roles_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Token>      $tokens
 * @property int|null                                                  $tokens_count
 *
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCurrentTeamId($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereProfilePhotoPath($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereTwoFactorConfirmedAt($value)
 * @method static Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static Builder|User whereTwoFactorSecret($value)
 * @method static Builder|User whereUpdatedAt($value)
 *
 * @mixin IdeHelperUser
 *
 * @property string|null $lang
 * @property int|null    $owned_teams_count
 * @property int|null    $teams_count
 *
 * @method static Builder|User whereLang($value)
 *
 * @property Team|null                                           $currentTeam
 * @property \Illuminate\Database\Eloquent\Collection<int, Team> $ownedTeams
 * @property \Modules\EWall\Models\Profile|null                  $profile
 * @property \Illuminate\Database\Eloquent\Collection<int, Team> $teams
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable implements \Modules\Xot\Contracts\UserContract, FilamentUser, HasTenants
{ /* , HasAvatar, UserJetContract, ExportsPersonalData */
    /* , HasTeamsContract */
    use HasApiTokens;
    use HasFactory;
    // use TwoFactorAuthenticatable; //ArtMin96
    // use CanExportPersonalData; //ArtMin96
    use HasRoles;
    // use HasProfilePhoto; //ArtMin96
    // use HasTeams; //ArtMin96
    use Traits\HasTeams;
    use Traits\HasTenants;
    //use Traits\HasProfilePhoto;
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lang',
        'current_team_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed', //Call to undefined cast [hashed] on column [password] in model [Modules\User\Models\User].
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
       // 'profile_photo_url',
    ];

    public function canAccessFilament(\Filament\Panel $panel): bool
    {
        // return $this->role_id === Role::ROLE_ADMINISTRATOR;
        return true;
    }

    public function profile(): HasOne
    {
        $profileClass = XotData::make()->getProfileClass();

        return $this->hasOne($profileClass);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true; // str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }

    // ----------------------
    // ----------------------
    // ---------------------


}