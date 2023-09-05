<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

/**
 * ---.
 */
interface ResetsUserPasswords
{
    public function reset(UserContract $userContract, array $input): void;
}
