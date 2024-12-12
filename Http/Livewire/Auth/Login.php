<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Xot\Actions\File\ViewCopyAction;
use Modules\Xot\Datas\XotData;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    /**
     * @var array<string, array<int, string>>
     */
    protected array $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    /**
     * Execute the action.
     *
     * @return RedirectResponse|void
     */
    public function authenticate()
    {
        $this->validate();
        $credentials = ['email' => $this->email, 'password' => $this->password];
        $remember = $this->remember;
        if (! Auth::attempt($credentials, $remember)) {
            $main_module = XotData::make()->main_module;
            $main_module_low = strtolower($main_module);

            $this->addError('email', trans($main_module_low.'::auth.failed'));

            return;
        }

        return redirect()->intended(route('home'));
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        app(ViewCopyAction::class)->execute('user::livewire.auth.login', 'pub_theme::livewire.auth.login');
        app(ViewCopyAction::class)->execute('user::layouts.auth', 'pub_theme::layouts.auth');
        app(ViewCopyAction::class)->execute('user::layouts.base', 'pub_theme::layouts.base');

        /**
         * @phpstan-var view-string
         */
        $view = 'pub_theme::livewire.auth.login';

        return view($view)
            ->extends('pub_theme::layouts.auth');
    }
}
