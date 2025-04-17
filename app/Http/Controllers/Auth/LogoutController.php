<?php

/**
 * Logs out the current user and redirects to the home page.
 *
 * @return \Illuminate\Http\RedirectResponse
 */

declare(strict_types=1);

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\User\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();

        return redirect(route('home'));
    }
}
