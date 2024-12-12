<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Livewire\Component;
use Modules\Xot\Datas\XotData;

class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    /**
     * Execute the action..
     */
    // public function register(): \Livewire\Features\SupportRedirects\Redirector
    public function register(): RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
    {
        $messages = __('user::validation');
        $this->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:user.users'],
            'password' => ['required', 'same:passwordConfirmation', PasswordRule::defaults()],
        ], $messages);
        $user_class = XotData::make()->getUserClass();

        /** @var \Modules\Xot\Contracts\UserContract */
        $user = $user_class::create([
            'email' => $this->email,
            'name' => $this->name,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(route('home'));
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        app(\Modules\Xot\Actions\File\ViewCopyAction::class)->execute('user::livewire.auth.register', 'pub_theme::livewire.auth.register');
        app(\Modules\Xot\Actions\File\ViewCopyAction::class)->execute('user::layouts.auth', 'pub_theme::layouts.auth');
        app(\Modules\Xot\Actions\File\ViewCopyAction::class)->execute('user::layouts.base', 'pub_theme::layouts.base');
        /**
         * @phpstan-var view-string
         */
        $view = 'pub_theme::livewire.auth.register';

        return view($view)
            ->extends('pub_theme::layouts.auth');
    }
}
