<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Modules\User\Datas\PasswordData;

class EditProfile extends BaseEditProfile
{
    public static ?string $title = 'Profilo Utente';

    /**
     * Costruisce il form schema per la pagina di modifica profilo.
     */
    public function getFormSchema(): array
{
    
        
    return [
              
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                ...PasswordData::make()->getPasswordFormComponents('new_password'),
            
      ];
}
}
