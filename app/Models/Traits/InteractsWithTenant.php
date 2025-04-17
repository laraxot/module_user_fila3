<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Scopes\TenantScope;
use Modules\Xot\Datas\XotData;

/**
 * @property TeamContract $currentTeam
 */
trait InteractsWithTenant
{
    /**
     * Relazione con il tenant a cui appartiene il modello.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Illuminate\Database\Eloquent\Model, self>
     * @phpstan-return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Illuminate\Database\Eloquent\Model, $this>
     */
    public function tenant(): BelongsTo
    {
        /** @var class-string<\Illuminate\Database\Eloquent\Model> $class */
        $class = XotData::make()->getTenantClass();

        return $this->belongsTo($class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function bootInteractsWithTenant(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(
            static function ($model): void {
                $model->tenant_id = Filament::getTenant()?->getKey();
            }
        );
    }

    /**
     * Interact with the user's first name.
     */
    protected function setTenantIdAttribute(?int $value): void
    {
        if ($value === null) {
            $value = Filament::getTenant()?->getKey();
        }
        $this->attributes['tenant_id'] = $value;
    }
}
