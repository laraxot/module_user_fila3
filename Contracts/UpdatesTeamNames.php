<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

/**
 * ---.
 */
interface UpdatesTeamNames
{
    public function update(UserContract $userContract, TeamContract $teamContract, array $input): void;
}
