<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Actions;

use Filament\Tables\Actions\Action;
use Modules\User\Actions\Otp\SendOtpByUserAction;
use Modules\User\Models\User;




use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;





class SendOtpAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            
            ->tooltip(trans('user::otp.actions.send_otp'))
            ->icon('heroicon-o-key')
            ->action(function (User $record) {
                if (! $record instanceof \Modules\Xot\Contracts\UserContract) {
                    throw new \InvalidArgumentException('L\'utente deve implementare l\'interfaccia UserContract');
                }
                app(SendOtpByUserAction::class)->execute($record);
            })
            ->requiresConfirmation()
            ->modalHeading(trans('user::otp.actions.send_otp'))
            ->modalSubheading(trans('user::otp.actions.confirm_otp'))
            ->modalButton(trans('user::otp.actions.yes_send_otp'));
    }

    /**
     * Ottieni il nome predefinito dell'azione.
     */
    public static function getDefaultName(): ?string
    {
        return 'send_otp';
    }
}
