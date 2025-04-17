# Correzioni PHPStan Livello 7 - Modulo User

Questo documento traccia gli errori PHPStan di livello 7 identificati nel modulo User e le relative soluzioni implementate.

## Errori Identificati

### 1. Errori in Profile.php

```
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::permission() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::role() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withExtraAttributes() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withoutPermission() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withoutRole() return type contains unknown class Modules\User\Models\Builder.
```

## Soluzioni Implementate

### 1. Correzione in Profile.php

Il problema è che i tag PHPDoc facevano riferimento a una classe `Builder` nel namespace `Modules\User\Models` che non esiste. Abbiamo corretto i riferimenti utilizzando il namespace completo per la classe Builder:

```php
/**
 * ...
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutRole($roles, $guard = null)
 * ...
 */
```

Questo garantisce che PHPStan possa risolvere correttamente il tipo `Builder` utilizzando il namespace completo `\Illuminate\Database\Eloquent\Builder`. 