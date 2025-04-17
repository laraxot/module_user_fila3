<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite\Utils;

use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User;
use Webmozart\Assert\Assert;

final class EmailDomainAnalyzer
{
    private User $ssoUser;

    public function __construct(
        private readonly string $ssoProvider,
    ) {}

    public function setUser(User $ssoUser): self
    {
        $this->ssoUser = $ssoUser;

        return $this;
    }

    public function hasUnrecognizedDomain(): bool
    {
        return ! $this->hasFirstPartyDomain() && ! $this->hasClientDomain();
    }

    public function hasFirstPartyDomain(): bool
    {
        return Str::of((string) $this->firstPartyDomain())
            ->after('@')
            ->exactly(
                Str::of((string) $this->ssoUser->getEmail())->after('@'),
            );
    }

    public function hasClientDomain(): bool
    {
        $clientEmailDomain = $this->clientDomain();

        if ($clientEmailDomain === null || $clientEmailDomain === '') {
            return false;
        }

        return Str::of($clientEmailDomain)
            ->after('@')
            ->exactly(
                Str::of((string) $this->ssoUser->getEmail())->after('@'),
            );
    }

    private function firstPartyDomain(): ?string
    {
        Assert::nullOrString($res = config(sprintf('services.%s.email_domains.first_party.tld', $this->ssoProvider)));

        return $res;
    }

    private function clientDomain(): ?string
    {
        $domain = config(sprintf('services.%s.email_domains.client.tld', $this->ssoProvider));
        if (is_string($domain)) {
            return $domain;
        }

        if (is_null($domain)) {
            return $domain;
        }

        throw new \Exception('wip');
        /*
        return empty($domain)
            ? null
            : $domain;
            */
    }
}
