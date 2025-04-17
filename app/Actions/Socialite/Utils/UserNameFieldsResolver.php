<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite\Utils;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Socialite\Contracts\User;

final class UserNameFieldsResolver
{
    private const NAME_SEARCH = 'before';

    private const SURNAME_SEARCH = 'after';

    public readonly ?string $name;

    public readonly ?string $first_name;

    public readonly ?string $last_name;

    public function __construct(User $user)
    {
        $this->name = $this->resolveName($user);
        $this->first_name = $this->resolveName($user);
        $this->last_name = $this->resolveSurname($user);
    }

    public static function make(User $user): self
    {
        return new self($user);
    }

    private function resolveName(User $idpUser): string
    {
        return $this->resolveNameFields($idpUser, self::NAME_SEARCH);
    }

    private function resolveSurname(User $idpUser): string
    {
        return $this->resolveNameFields($idpUser, self::SURNAME_SEARCH);
    }

    /**
     * @param  string  $searchMethod  use self constants (NAME_SEARCH, SURNAME_SEARCH)
     */
    private function resolveNameFields(User $idpUser, string $searchMethod): string
    {
        // Silly way: trying to split name field on first blank space
        // occurrence. If we're lucky, this will be enough.

        $nameSection = $this->resolveNameFieldByNameAttributeAnalysis((string) $idpUser->getName(), $searchMethod);

        if ($nameSection->isNotEmpty()) {
            return (string) $nameSection;
        }

        // If the section was empty, try the "hard way"
        // by analyzing raw user data
        $nameField = method_exists($idpUser, 'getRaw')
            ? ($idpUser->getRaw()['name'] ?? '')
            : '';
        $nameSection = $this->resolveNameFieldByNameAttributeAnalysis((string) $nameField, $searchMethod);
        if (! $nameSection->isNotEmpty()) {
            // If both sections were empty, try the "hardest way"
            // by analyzing email address
            return Str::of((string) $idpUser->getEmail())
                ->trim()
                ->before('@')
                ->$searchMethod('.') // If no point is available, the whole string should be returned
                ->trim()
                ->title()
                ->toString();
        }
        if (filter_var((string) $nameSection, FILTER_VALIDATE_EMAIL)) {
            // If both sections were empty, try the "hardest way"
            // by analyzing email address
            return Str::of((string) $idpUser->getEmail())
                ->trim()
                ->before('@')
                ->$searchMethod('.') // If no point is available, the whole string should be returned
                ->trim()
                ->title()
                ->toString();
        }

        return (string) $nameSection;
    }

    private function resolveNameFieldByNameAttributeAnalysis(string $nameField, string $searchMethod): Stringable
    {
        return Str::of($nameField)
            ->trim()
            ->$searchMethod(' ')
            ->trim();
    }
}
