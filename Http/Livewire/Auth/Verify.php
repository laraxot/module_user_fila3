<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Webmozart\Assert\Assert;

class Verify extends Component
{
    public function resend(): void
    {
        Assert::notNull($user = Auth::user(), '['.__LINE__.']['.class_basename($this).']');
        if ($user->hasVerifiedEmail()) {
            redirect(route('home'));
        }

        $user->sendEmailVerificationNotification();

        $this->dispatch('resent');

        session()->flash('resent');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        app(\Modules\Xot\Actions\File\ViewCopyAction::class)->execute('user::livewire.auth.verify', 'pub_theme::livewire.auth.verify');
        app(\Modules\Xot\Actions\File\ViewCopyAction::class)->execute('user::layouts.auth', 'pub_theme::layouts.auth');
        app(\Modules\Xot\Actions\File\ViewCopyAction::class)->execute('user::layouts.base', 'pub_theme::layouts.base');
        /**
         * @phpstan-var view-string
         */
        $view = 'pub_theme::livewire.auth.verify';

        return view($view)
            ->extends('pub_theme::layouts.auth');
    }
}
