<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\User\Contracts\TeamContract;
use Modules\User\Database\Factories\TeamInvitationFactory;
use Modules\Xot\Datas\XotData;

/**
 * Modules\User\Models\TeamInvitation.
 *
 * @property int               $id
 * @property string|null       $team_id
 * @property string            $email
 * @property string|null       $role
 * @property Carbon|null       $created_at
 * @property Carbon|null       $updated_at
 * @property Team|null         $team
 * @property TeamContract|null $team
 *
 * @method static TeamInvitationFactory                                factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereUpdatedAt($value)
 *
 * @property string      $uuid
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereUuid($value)
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @mixin \Eloquent
 */
class TeamInvitation extends BaseModel
{
    /** @var string */
    protected $connection = 'user';

    /** @var list<string> */
    protected $fillable = [
        'email',
        'role',
    ];

    /**
     * Get the team that the invitation belongs to.
     *  BelongsTo<the related model, the current model>
     * -return BelongsTo<TeamContract, TeamInvitation> No TeamContract ..
     */
    public function team(): BelongsTo
    {
        $xotData = XotData::make();
        /** @var class-string<\Illuminate\Database\Eloquent\Model> */
        $team_class = $xotData->getTeamClass();

        return $this->belongsTo($team_class);
    }
}
